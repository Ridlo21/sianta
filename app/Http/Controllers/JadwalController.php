<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\JadwalVersion;
use App\Models\Jurusan;
use App\Models\Pembelajaran;
use App\Models\Periode;
use App\Models\Rombel;
use App\Models\SlotWaktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('status', 1)->first();
        if (!$periodeAktif) {
            return redirect()->route('periode')->with('error', 'Silakan aktifkan periode akademik terlebih dahulu.');
        }

        // Auto-create default version if none exists
        $versions = JadwalVersion::where('periode_akademik_id', $periodeAktif->id)->get();
        if ($versions->isEmpty()) {
            $defaultVersion = JadwalVersion::create([
                'periode_akademik_id' => $periodeAktif->id,
                'nama_versi' => 'Jadwal Rilis Utama',
                'is_active' => true,
            ]);
            $versions = collect([$defaultVersion]);
        }

        $activeVersion = $versions->firstWhere('is_active', true) ?? $versions->first();
        
        // Fetch active schedule data to display preview grid
        $slotWaktus = SlotWaktu::orderBy('hari')->orderBy('jam_ke')->get();
        $jurusans = Jurusan::all();

        $user = auth()->user();
        $title = 'Manajemen Jadwal Pelajaran';
        return view('admin.jadwal.index', compact('title', 'user', 'periodeAktif', 'versions', 'activeVersion', 'slotWaktus', 'jurusans'));
    }

    public function createVersion(Request $request)
    {
        $request->validate([
            'nama_versi' => 'required|string|max:255',
        ]);

        $periodeAktif = Periode::where('status', 1)->first();
        if (!$periodeAktif) {
            return back()->with('error', 'Tidak ada periode akademik aktif.');
        }

        // Deactivate other versions if this is marked active (optional, here we set default false first)
        $hasActive = JadwalVersion::where('periode_akademik_id', $periodeAktif->id)
            ->where('is_active', true)
            ->exists();

        JadwalVersion::create([
            'periode_akademik_id' => $periodeAktif->id,
            'nama_versi' => $request->nama_versi,
            'is_active' => !$hasActive, // Active if it's the first one
        ]);

        return back()->with('success', 'Versi jadwal baru berhasil dibuat.');
    }

    public function backupVersion($id)
    {
        $sourceVersion = JadwalVersion::findOrFail($id);

        return DB::transaction(function () use ($sourceVersion) {
            $newVersion = JadwalVersion::create([
                'periode_akademik_id' => $sourceVersion->periode_akademik_id,
                'nama_versi' => 'Backup ' . $sourceVersion->nama_versi . ' - ' . date('d M Y H:i'),
                'is_active' => false,
            ]);

            // Copy all jadwal entries
            $entries = Jadwal::where('version_id', $sourceVersion->id)->get();
            foreach ($entries as $entry) {
                Jadwal::create([
                    'version_id' => $newVersion->id,
                    'slot_waktu_id' => $entry->slot_waktu_id,
                    'pembelajaran_id' => $entry->pembelajaran_id,
                ]);
            }

            return back()->with('success', 'Versi jadwal "' . $sourceVersion->nama_versi . '" berhasil di-backup.');
        });
    }

    public function activateVersion($id)
    {
        $version = JadwalVersion::findOrFail($id);

        DB::transaction(function () use ($version) {
            JadwalVersion::where('periode_akademik_id', $version->periode_akademik_id)
                ->update(['is_active' => false]);

            $version->update(['is_active' => true]);
        });

        return back()->with('success', 'Versi jadwal "' . $version->nama_versi . '" sekarang menjadi aktif.');
    }

    public function deleteVersion($id)
    {
        $version = JadwalVersion::findOrFail($id);
        if ($version->is_active) {
            return back()->with('error', 'Versi aktif tidak dapat dihapus. Silakan aktifkan versi lain terlebih dahulu.');
        }

        $version->delete();
        return back()->with('success', 'Versi jadwal berhasil dihapus.');
    }

    public function edit($id)
    {
        $version = JadwalVersion::findOrFail($id);
        $periodeAktif = Periode::where('status', 1)->first();

        // Get rombels active in the current academic year
        // We match rombel's tahun_ajaran with the active academic period
        // E.g. periode_akademik: 2025/2026. rombel has tahun_ajaran_id.
        // Let's find tahun_ajaran matching the year of periode
        $tahunAjaranNama = $periodeAktif->awal . '/' . $periodeAktif->akhir;
        $tahunAjaran = \App\Models\TahunAjaran::where('tahun_ajaran', $tahunAjaranNama)->first();
        $tahunAjaranId = $tahunAjaran ? $tahunAjaran->id : null;

        $rombelsQuery = Rombel::query();
        if ($tahunAjaranId) {
            $rombelsQuery->where('tahun_ajaran_id', $tahunAjaranId);
        }
        $rombels = $rombelsQuery->with('jurusan', 'kelas')->get();

        $slotWaktus = SlotWaktu::orderBy('hari')->orderBy('jam_ke')->get();

        // Fetch all pembelajaran options grouped by Rombel
        $pembelajaranData = Pembelajaran::where('status_aktif', 1)
            ->with(['mataPelajaran', 'guru'])
            ->get()
            ->groupBy('rombel_id');

        // Fetch current jadwal assignments
        $currentJadwal = Jadwal::where('version_id', $version->id)
            ->get()
            ->groupBy(function ($j) {
                return $j->slot_waktu_id;
            })
            ->map(function ($items) {
                return $items->keyBy(function ($item) {
                    return $item->pembelajaran->rombel_id;
                });
            });

        $user = auth()->user();
        $title = 'Edit Jadwal: ' . $version->nama_versi;
        return view('admin.jadwal.edit', compact(
            'title', 'user', 'version', 'periodeAktif', 'rombels', 'slotWaktus', 'pembelajaranData', 'currentJadwal'
        ));
    }

    public function save(Request $request)
    {
        $versionId = $request->input('version_id');
        $version = JadwalVersion::findOrFail($versionId);
        $assignments = $request->input('assignments', []); // Grid format: assignments[slot_id][rombel_id] = pembelajaran_id

        // Validate teacher conflicts (bentrok guru)
        // Group assignments by slot_waktu_id and check if the same guru is assigned to multiple rombels at the same time
        foreach ($assignments as $slotId => $rombelAssignments) {
            $assignedPembelajaranIds = array_filter($rombelAssignments); // Remove empty values
            if (empty($assignedPembelajaranIds)) {
                continue;
            }

            // Retrieve the pembelajaran entries for this slot
            $pembelajarans = Pembelajaran::whereIn('id', $assignedPembelajaranIds)->with('guru', 'rombel', 'mataPelajaran')->get();
            
            // Check for duplicated guru_id
            $guruAssignments = [];
            foreach ($pembelajarans as $p) {
                if ($p->guru_id) {
                    if (isset($guruAssignments[$p->guru_id])) {
                        $slot = SlotWaktu::find($slotId);
                        $guruName = $p->guru->nama_lengkap;
                        $firstRombel = $guruAssignments[$p->guru_id]->rombel->nama_rombel;
                        $secondRombel = $p->rombel->nama_rombel;
                        
                        return response()->json([
                            'status' => 'error',
                            'message' => "Bentrok Jadwal! Guru '{$guruName}' dijadwalkan mengajar pada hari {$slot->hari} jam ke-{$slot->jam_ke} ({$slot->waktu_mulai} - {$slot->waktu_selesai}) di kelas '{$firstRombel}' dan '{$secondRombel}' secara bersamaan."
                        ], 422);
                    }
                    $guruAssignments[$p->guru_id] = $p;
                }
            }
        }

        // Save assignments
        DB::transaction(function () use ($version, $assignments) {
            // Delete old assignments
            Jadwal::where('version_id', $version->id)->delete();

            // Insert new assignments
            foreach ($assignments as $slotId => $rombelAssignments) {
                foreach ($rombelAssignments as $rombelId => $pembelajaranId) {
                    if ($pembelajaranId) {
                        Jadwal::create([
                            'version_id' => $version->id,
                            'slot_waktu_id' => $slotId,
                            'pembelajaran_id' => $pembelajaranId,
                        ]);
                    }
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil disimpan.'
        ]);
    }

    public function print(Request $request, $id)
    {
        $version = JadwalVersion::findOrFail($id);
        $periodeAktif = $version->periode;

        // Filter by Jurusan
        $selectedJurusanAlias = $request->query('jurusan', 'AKL');
        $jurusan = Jurusan::where('kons_keahlian', 'like', "%{$selectedJurusanAlias}%")
            ->orWhere('program_keahlian', 'like', "%{$selectedJurusanAlias}%")
            ->orWhere('kode_nomenklatur', 'like', "%{$selectedJurusanAlias}%")
            ->first();

        // Get rombels for this jurusan in active academic year
        $tahunAjaranNama = $periodeAktif->awal . '/' . $periodeAktif->akhir;
        $tahunAjaran = \App\Models\TahunAjaran::where('tahun_ajaran', $tahunAjaranNama)->first();
        $tahunAjaranId = $tahunAjaran ? $tahunAjaran->id : null;

        $rombelsQuery = Rombel::query();
        if ($tahunAjaranId) {
            $rombelsQuery->where('tahun_ajaran_id', $tahunAjaranId);
        }
        if ($jurusan) {
            $rombelsQuery->where('jurusan_id', $jurusan->id);
        }
        $rombels = $rombelsQuery->with('waliRombel.guru')->get();

        $slotWaktus = SlotWaktu::orderBy('hari')->orderBy('jam_ke')->get();

        // Fetch jadwal entries for this version and this jurusan's rombels
        $rombelIds = $rombels->pluck('id');
        $jadwals = Jadwal::where('version_id', $version->id)
            ->whereHas('pembelajaran', function ($q) use ($rombelIds) {
                $q->whereIn('rombel_id', $rombelIds);
            })
            ->with(['pembelajaran.mataPelajaran', 'pembelajaran.guru'])
            ->get();

        // Map schedules to Grid
        $grid = [];
        foreach ($jadwals as $j) {
            $grid[$j->slot_waktu_id][$j->pembelajaran->rombel_id] = $j;
        }

        // Generate dynamic codes for Guru (e.g. 1, 2, 3...)
        // Gather all unique teachers in this schedule or in the database
        $uniqueGurus = $jadwals->pluck('pembelajaran.guru')->filter()->unique('id')->values();
        $guruCodes = [];
        foreach ($uniqueGurus as $index => $g) {
            $guruCodes[$g->id] = [
                'code' => $index + 1,
                'name' => $g->nama_lengkap
            ];
        }

        // Gather mata pelajaran in the schedule
        $uniqueMapels = $jadwals->pluck('pembelajaran.mataPelajaran')->filter()->unique('id')->values();
        
        // Group mapel by category if possible
        $groupedMapels = $uniqueMapels->groupBy(function ($m) {
            // e.g. A. Muatan Nasional, B. Dasar Program Keahlian, C. Konsentrasi Keahlian, D. Muatan Lokal
            if (isset($m->kelompok)) {
                return $m->kelompok;
            }
            // fallback
            return 'A. Muatan Pelajaran';
        });

        // Wali Kelas list
        $waliKelasList = [];
        foreach ($rombels as $r) {
            $wali = \App\Models\WaliRombel::where('rombel_id', $r->id)->where('status', 1)->with('guru')->first();
            $waliKelasList[$r->nama_rombel] = $wali ? $wali->guru->nama_lengkap : '-';
        }

        return view('admin.jadwal.print', compact(
            'version', 'periodeAktif', 'rombels', 'slotWaktus', 'grid', 'guruCodes', 'groupedMapels', 'waliKelasList', 'selectedJurusanAlias'
        ));
    }
}
