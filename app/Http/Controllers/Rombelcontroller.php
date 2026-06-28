<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\PenempatanRombel;
use App\Models\WaliRombel;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Rombelcontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Rombel';
        $tahun = TahunAjaran::where('status', '1')->first();
        $kelas = Kelas::with(['rombel' => function ($query) use ($tahun) {
            if ($tahun) {
                $query->where('tahun_ajaran_id', $tahun->id);
            }
            $query->with(['jurusan'])->withCount(['penempatanRombel' => function ($q) {
                $q->where('status_aktif', 1);
            }]);
        }])->get();

        $jurusan = Jurusan::where('status', 'Aktif')->get();

        return view('admin.rombel.index', compact('title', 'user', 'tahun', 'kelas', 'jurusan'));
    }

    public function getStudents($id)
    {
        $rombel = Rombel::with(['kelas', 'jurusan'])->findOrFail($id);
        $placements = PenempatanRombel::where('rombel_id', $id)
            ->where('status_aktif', 1)
            ->with('siswa')
            ->get();

        return response()->json([
            'rombel' => $rombel,
            'students' => $placements->map(function ($p) {
                return $p->siswa;
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_rombel' => 'required|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        $tahun = TahunAjaran::where('status', '1')->first();
        if (!$tahun) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada Tahun Ajaran aktif.'
            ]);
        }

        Rombel::create([
            'kelas_id' => $request->kelas_id,
            'nama_rombel' => $request->nama_rombel,
            'jurusan_id' => $request->jurusan_id,
            'tahun_ajaran_id' => $tahun->id,
            'status' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rombel berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        $rombel = Rombel::findOrFail($id);
        return response()->json($rombel);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:rombel,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_rombel' => 'required|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        Rombel::where('id', $request->id)->update([
            'kelas_id' => $request->kelas_id,
            'nama_rombel' => $request->nama_rombel,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rombel berhasil diperbarui.'
        ]);
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:rombel,id',
        ]);

        // Check if there are active student placements in this rombel
        $hasStudents = PenempatanRombel::where('rombel_id', $request->id)
            ->where('status_aktif', 1)
            ->exists();

        if ($hasStudents) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rombel tidak dapat dihapus karena masih memiliki siswa aktif.'
            ]);
        }

        Rombel::where('id', $request->id)->update([
            'status' => 0
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rombel berhasil dihapus.'
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $title = 'Kelola Detail Rombel';
        $tahun = TahunAjaran::where('status', '1')->first();
        $rombel = Rombel::with(['kelas', 'jurusan'])->findOrFail($id);

        // Fetch students currently assigned to this Rombel
        $students = PenempatanRombel::where('rombel_id', $id)
            ->where('status_aktif', 1)
            ->with('siswa')
            ->get()
            ->pluck('siswa');

        // Fetch active Wali Rombel (homeroom teacher) for the active academic year
        $activeWali = null;
        if ($tahun) {
            $activeWali = WaliRombel::where('rombel_id', $id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->where('status', 1)
                ->with('guru')
                ->first();
        }

        // Fetch list of all active Gurus to choose from
        $gurus = Guru::where('status_aktif', 1)->get();

        // Fetch list of all other Rombels in the active academic year (for moving students)
        $otherRombels = Rombel::where('id', '!=', $id)
            ->when($tahun, function ($q) use ($tahun) {
                $q->where('tahun_ajaran_id', $tahun->id);
            })
            ->with(['kelas', 'jurusan'])
            ->get();

        // Fetch list of active students who have no rombel placement for the active year
        $unassignedStudents = collect();
        if ($tahun) {
            $unassignedStudents = Siswa::where('status', 'Aktif')
                ->whereNotExists(function ($query) use ($tahun) {
                    $query->select(DB::raw(1))
                        ->from('penempatan_rombel')
                        ->whereColumn('penempatan_rombel.siswa_id', 'siswa.id_person')
                        ->where('penempatan_rombel.status_aktif', 1)
                        ->where('penempatan_rombel.tahun_ajaran_id', $tahun->id);
                })
                ->when($rombel->jurusan_id, function ($query) use ($rombel) {
                    $query->where('siswa.jurusan_id', $rombel->jurusan_id);
                })
                ->orderBy('nama', 'asc')
                ->get();
        }

        return view('admin.rombel.show', compact('title', 'user', 'tahun', 'rombel', 'students', 'activeWali', 'gurus', 'otherRombels', 'unassignedStudents'));
    }

    public function setWali(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombel,id',
            'guru_id' => 'required|exists:guru,id',
        ]);

        $tahun = TahunAjaran::where('status', '1')->first();
        if (!$tahun) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada Tahun Ajaran aktif.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Disable any existing active wali for this rombel in current year
            WaliRombel::where('rombel_id', $request->rombel_id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->update(['status' => 0]);

            // Set new wali
            WaliRombel::create([
                'rombel_id' => $request->rombel_id,
                'guru_id' => $request->guru_id,
                'tahun_ajaran_id' => $tahun->id,
                'status' => 1
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Wali Kelas berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui Wali Kelas: ' . $e->getMessage()
            ]);
        }
    }

    public function pindahSiswa(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'required|exists:siswa,id_person',
            'target_rombel_id' => 'required|exists:rombel,id',
            'source_rombel_id' => 'required|exists:rombel,id',
        ]);

        $tahun = TahunAjaran::where('status', '1')->first();
        if (!$tahun) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada Tahun Ajaran aktif.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Loop and deactivate current placements
            PenempatanRombel::whereIn('siswa_id', $request->siswa_ids)
                ->where('rombel_id', $request->source_rombel_id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->update(['status_aktif' => 0]);

            // Create new placements
            foreach ($request->siswa_ids as $siswaId) {
                PenempatanRombel::create([
                    'rombel_id' => $request->target_rombel_id,
                    'siswa_id' => $siswaId,
                    'tahun_ajaran_id' => $tahun->id,
                    'status_aktif' => 1
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Siswa berhasil dipindahkan ke rombel baru.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memindahkan siswa: ' . $e->getMessage()
            ]);
        }
    }

    public function tambahSiswa(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombel,id',
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'required|exists:siswa,id_person',
        ]);

        $tahun = TahunAjaran::where('status', '1')->first();
        if (!$tahun) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada Tahun Ajaran aktif.'
            ]);
        }

        DB::beginTransaction();
        try {
            foreach ($request->siswa_ids as $siswaId) {
                PenempatanRombel::where('siswa_id', $siswaId)
                    ->where('tahun_ajaran_id', $tahun->id)
                    ->update(['status_aktif' => 0]);

                PenempatanRombel::create([
                    'rombel_id' => $request->rombel_id,
                    'siswa_id' => $siswaId,
                    'tahun_ajaran_id' => $tahun->id,
                    'status_aktif' => 1
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Siswa berhasil ditambahkan ke Rombel.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan siswa: ' . $e->getMessage()
            ]);
        }
    }

    public function pembagianMassal()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $title = 'Pembagian Kelas Massal';
        $tahun = TahunAjaran::where('status', '1')->first();

        $students = collect();
        if ($tahun) {
            $students = Siswa::where('status', 'Aktif')
                ->whereNotExists(function ($query) use ($tahun) {
                    $query->select(DB::raw(1))
                        ->from('penempatan_rombel')
                        ->whereColumn('penempatan_rombel.siswa_id', 'siswa.id_person')
                        ->where('penempatan_rombel.status_aktif', 1)
                        ->where('penempatan_rombel.tahun_ajaran_id', $tahun->id);
                })
                ->with('jurusan')
                ->orderBy('nama', 'asc')
                ->get();
        }

        $rombels = Rombel::when($tahun, function ($q) use ($tahun) {
            $q->where('tahun_ajaran_id', $tahun->id);
        })
            ->with(['kelas', 'jurusan'])
            ->withCount(['penempatanRombel' => function ($q) {
                $q->where('status_aktif', 1);
            }])
            ->with(['waliRombel' => function ($q) use ($tahun) {
                $q->where('status', 1)->where('tahun_ajaran_id', $tahun->id)->with('guru');
            }])
            ->get();

        return view('admin.rombel.pembagian_massal', compact('title', 'user', 'tahun', 'students', 'rombels'));
    }

    public function prosesPembagianMassal(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'required|exists:siswa,id_person',
            'rombel_id' => 'required|exists:rombel,id',
        ]);

        $tahun = TahunAjaran::where('status', '1')->first();
        if (!$tahun) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada Tahun Ajaran aktif.'
            ]);
        }

        DB::beginTransaction();
        try {
            foreach ($request->siswa_ids as $siswaId) {
                PenempatanRombel::where('siswa_id', $siswaId)
                    ->where('tahun_ajaran_id', $tahun->id)
                    ->update(['status_aktif' => 0]);

                PenempatanRombel::create([
                    'rombel_id' => $request->rombel_id,
                    'siswa_id' => $siswaId,
                    'tahun_ajaran_id' => $tahun->id,
                    'status_aktif' => 1
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Siswa berhasil ditempatkan ke Rombel secara massal.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menempatkan siswa: ' . $e->getMessage()
            ]);
        }
    }

    public function print($id)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $rombel = Rombel::with(['kelas', 'jurusan'])->findOrFail($id);

        $placements = PenempatanRombel::where('rombel_id', $id)
            ->where('status_aktif', 1)
            ->with('siswa')
            ->get();
            
        $students = $placements->pluck('siswa')->sortBy('nama')->values();

        $tahun = TahunAjaran::where('status', '1')->first();
        $periode = \App\Models\Periode::where('status', 1)->first();

        return view('admin.rombel.print', compact('rombel', 'students', 'tahun', 'periode'));
    }
}
