<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class Jurusancontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Jurusan';
        return view('admin.jurusan.index', compact('title', 'user'));
    }

    public function jurusan_data()
    {
        $jurusan = Jurusan::where('status', 'Aktif')->orderBy('id', 'desc')->get();

        return DataTables::of($jurusan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                        <div class="d-flex gap-1">
                            <button class="btn btn-warning btnEdit" data-id="' . $row->id . '" title="Edit Jurusan">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-danger btHapus" data-id="' . $row->id_person . '" title="Hapus Jurusan">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        ';
                return $btn;
            })
            ->addColumn('stats', function ($row) {
                if ($row->status == 'Aktif') {
                    $badge = '<span class="badge badge-success-light">Aktif</span>';
                } else {
                    $badge = '<span class="badge badge-danger-light">Nonaktif</span>';
                }
                $bt = $badge;
                return $bt . "";
            })
            ->rawColumns(['action', 'stats'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_nomenklatur' => 'required',
            'bidang_keahlian' => 'required',
            'program_keahlian' => 'required',
            'kons_keahlian' => 'required',
            'deskripsi' => 'required',
        ]);

        $cek = Jurusan::where('kode_nomenklatur', $request->kode_nomenklatur)
            ->exists();

        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode jurusan tersebut sudah terpakai.'
            ]);
        }

        Jurusan::create([
            'kode_nomenklatur' => $request->kode_nomenklatur,
            'bidang_keahlian' => $request->bidang_keahlian,
            'program_keahlian' => $request->program_keahlian,
            'kons_keahlian' => $request->kons_keahlian,
            'deskripsi' => $request->deskripsi,
            'status' => 'Aktif'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data Jurusan berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $data = Jurusan::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'kode_nomenklatur' => 'required',
            'bidang_keahlian' => 'required',
            'program_keahlian' => 'required',
            'kons_keahlian' => 'required',
            'deskripsi' => 'required',
        ]);

        Jurusan::where('id', $request->id)->update([
            'kode_nomenklatur' => $request->kode_nomenklatur,
            'bidang_keahlian' => $request->bidang_keahlian,
            'program_keahlian' => $request->program_keahlian,
            'kons_keahlian' => $request->kons_keahlian,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data Jurusan berhasil diedit.']);
    }
}
