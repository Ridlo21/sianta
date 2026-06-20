<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\Pembelajaran;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelajaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $title = 'Sebaran Mapel';
        $tahun = TahunAjaran::where('status', '1')->first();

        // Fetch all rombels for the active academic year
        $rombels = collect();
        if ($tahun) {
            $rombels = Rombel::where('tahun_ajaran_id', $tahun->id)
                ->with(['kelas', 'jurusan'])
                ->withCount(['pembelajaran' => function ($q) {
                    $q->where('status_aktif', 1);
                }])
                ->withSum(['pembelajaran as total_jam' => function ($q) {
                    $q->where('status_aktif', 1);
                }], 'jam_mengajar')
                ->with(['waliRombel' => function ($q) use ($tahun) {
                    $q->where('status', 1)->where('tahun_ajaran_id', $tahun->id)->with('guru');
                }])
                ->get();
        }

        return view('admin.sebaran_mapel.index', compact('title', 'user', 'tahun', 'rombels'));
    }

    public function manage($id)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $tahun = TahunAjaran::where('status', '1')->first();
        $rombel = Rombel::with(['kelas', 'jurusan'])->findOrFail($id);

        $title = 'Kelola Sebaran Mapel - ' . $rombel->nama_rombel;

        // Fetch active subjects in this rombel
        $pembelajaranList = Pembelajaran::where('rombel_id', $id)
            ->where('status_aktif', 1)
            ->with(['mataPelajaran', 'guru'])
            ->get();

        // Group by subject kelompok (General, Vocational, Choice, etc.)
        $groupedPembelajaran = $pembelajaranList->groupBy(function($item) {
            return $item->mataPelajaran ? $item->mataPelajaran->kelompok : 'Lainnya';
        });

        // Get master subjects that are active and NOT already in this rombel
        $alreadyAssignedMapelIds = $pembelajaranList->pluck('mapel_id')->toArray();
        $availableMapels = MataPelajaran::where('status', 1)
            ->whereNotIn('id', $alreadyAssignedMapelIds)
            ->orderBy('nama_mapel', 'asc')
            ->get();

        // Get active teachers
        $gurus = Guru::where('status_aktif', 1)->orderBy('nama', 'asc')->get();

        // Calculate total teaching hours in this rombel
        $totalHours = $pembelajaranList->sum('jam_mengajar');

        return view('admin.sebaran_mapel.manage', compact(
            'title', 'user', 'tahun', 'rombel', 'groupedPembelajaran', 
            'availableMapels', 'gurus', 'totalHours'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombel,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'nullable|exists:guru,id',
            'sk_mengajar' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'jam_mengajar' => 'required|integer|min:0|max:48',
        ]);

        // Check if mapel already assigned
        $exists = Pembelajaran::where('rombel_id', $request->rombel_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('status_aktif', 1)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mata pelajaran tersebut sudah dimasukkan ke dalam Rombel ini.'
            ]);
        }

        Pembelajaran::create([
            'rombel_id' => $request->rombel_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'sk_mengajar' => $request->sk_mengajar,
            'tanggal_sk' => $request->tanggal_sk,
            'jam_mengajar' => $request->jam_mengajar,
            'status_aktif' => 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mata pelajaran berhasil disebarkan ke Rombel.'
        ]);
    }

    public function edit($id)
    {
        $data = Pembelajaran::with(['mataPelajaran', 'guru'])->findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pembelajaran,id',
            'guru_id' => 'nullable|exists:guru,id',
            'sk_mengajar' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'jam_mengajar' => 'required|integer|min:0|max:48',
        ]);

        Pembelajaran::where('id', $request->id)->update([
            'guru_id' => $request->guru_id,
            'sk_mengajar' => $request->sk_mengajar,
            'tanggal_sk' => $request->tanggal_sk,
            'jam_mengajar' => $request->jam_mengajar,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sebaran Mata Pelajaran berhasil diperbarui.'
        ]);
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pembelajaran,id',
        ]);

        Pembelajaran::where('id', $request->id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Mata pelajaran berhasil dihapus dari sebaran Rombel.'
        ]);
    }
}
