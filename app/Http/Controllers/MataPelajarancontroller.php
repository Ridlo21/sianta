<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MataPelajarancontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Mata Pelajaran';
        return view('admin.mapel.index', compact('title', 'user'));
    }

    public function mapel_data()
    {
        $mapel = MataPelajaran::orderBy('id', 'desc')->get();

        return DataTables::of($mapel)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex gap-1">
                        <button class="btn btn-warning btnEdit" data-id="' . $row->id . '" title="Edit Mapel">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger btnHapus" data-id="' . $row->id . '" title="Hapus Mapel">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                ';
            })
            ->addColumn('stats', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-success-light">Aktif</span>';
                } else {
                    return '<span class="badge badge-danger-light">Nonaktif</span>';
                }
            })
            ->rawColumns(['action', 'stats'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:50',
            'nama_mapel' => 'required|string|max:255',
            'kelompok' => 'required|in:Umum,Kejuruan,Pilihan,Muatan Lokal,Tambahan',
        ]);

        $cek = MataPelajaran::where('kode_mapel', $request->kode_mapel)->exists();
        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode mata pelajaran tersebut sudah terpakai.'
            ]);
        }

        MataPelajaran::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kelompok' => $request->kelompok,
            'status' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Mata Pelajaran berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        $data = MataPelajaran::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mata_pelajaran,id',
            'kode_mapel' => 'required|string|max:50',
            'nama_mapel' => 'required|string|max:255',
            'kelompok' => 'required|in:Umum,Kejuruan,Pilihan,Muatan Lokal,Tambahan',
        ]);

        // Check uniqueness excluding current ID
        $cek = MataPelajaran::where('kode_mapel', $request->kode_mapel)
            ->where('id', '!=', $request->id)
            ->exists();
        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode mata pelajaran tersebut sudah terpakai.'
            ]);
        }

        MataPelajaran::where('id', $request->id)->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kelompok' => $request->kelompok,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Mata Pelajaran berhasil diperbarui.'
        ]);
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mata_pelajaran,id',
        ]);

        MataPelajaran::where('id', $request->id)->update(['status' => 0]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Mata Pelajaran berhasil dinonaktifkan.'
        ]);
    }
}
