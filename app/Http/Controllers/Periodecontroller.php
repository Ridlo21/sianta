<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Periodecontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Periode Akademik';
        return view('admin.periode.index', compact('title', 'user'));
    }

    public function periode_data()
    {
        $periode = Periode::orderBy('id', 'desc')->get();

        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->status == 0) {
                    $btn = '<button class="btn btn-warning" disabled title="Edit Periode">
                                <i class="fas fa-pencil-alt"></i>
                            </button>';
                } else {
                    $btn = '<button class="btn btn-warning btnEdit" data-id="' . $row->id . '" title="Edit Periode">
                                <i class="fas fa-pencil-alt"></i>
                            </button>';
                }

                return $btn;
            })
            ->addColumn('tahun', function ($row) {
                $bt = $row->awal . "/" . $row->akhir;
                return $bt . "";
            })
            ->addColumn('stats', function ($row) {
                if ($row->status == 1) {
                    $badge = '<span class="badge badge-success-light">Aktif</span>';
                } else {
                    $badge = '<span class="badge badge-danger-light">Nonaktif</span>';
                }
                $bt = $badge;
                return $bt . "";
            })
            ->rawColumns(['action', 'tahun', 'stats'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'awal' => 'required|integer',
            'akhir' => 'required|integer|gt:awal',
            'semester' => 'required',
        ], [
            'akhir.gt' => 'Tahun akhir harus lebih besar dari tahun awal.',
        ]);

        $cek = Periode::where('awal', $request->awal)
            ->where('akhir', $request->akhir)
            ->where('semester', $request->semester)
            ->exists();

        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode akademik tersebut sudah tersedia.'
            ]);
        }

        DB::transaction(function () use ($request) {

            // Nonaktifkan semua periode
            Periode::query()->update([
                'status' => 0
            ]);

            // Simpan periode baru
            Periode::create([
                'awal'     => $request->awal,
                'akhir'    => $request->akhir,
                'semester' => $request->semester,
                'status'   => 1,
            ]);

            // Hanya jika semester ganjil
            if ($request->semester == 'Ganjil') {

                // Nonaktifkan semua tahun ajaran
                TahunAjaran::query()->update([
                    'status' => 0
                ]);

                // Simpan tahun ajaran baru
                TahunAjaran::create([
                    'tahun_ajaran' => $request->awal . '/' . $request->akhir,
                    'status' => 1,
                ]);
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data Periode berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        $data = Periode::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'awal' => 'required|integer',
            'akhir' => 'required|integer|gt:awal',
            'semester' => 'required',
        ], [
            'akhir.gt' => 'Tahun akhir harus lebih besar dari tahun awal.',
        ]);

        Periode::where('id', $request->id)->update([
            'awal'     => $request->awal,
            'akhir'    => $request->akhir,
            'semester' => $request->semester,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data Periode berhasil diedit.']);
    }
}
