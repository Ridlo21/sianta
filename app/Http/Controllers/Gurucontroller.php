<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Desa;
use App\Models\Guru;
use App\Models\Gurukeluarga;
use App\Models\Jurusan;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\PendidikanGuru;
use App\Models\PenugasanGuru;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Gurucontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru';

        return view('admin.guru.index', compact('title', 'user'));
    }

    public function guru_data()
    {
        $guru = Guru::where('status_aktif', '1')->orderBy('id', 'desc')->get();

        return DataTables::of($guru)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                        <div class="d-flex gap-1">
                            <a href="' . route('guru.show', $row->id) . '" class="btn btn-info" title="Detail guru">
                                <i class="fas fa-info"></i>
                            </a>
                            <a href="' . route('guru.edit.step1', [$row->id, 'e']) . '" class="btn btn-warning" title="Edit guru">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="' . route('guru.upload', $row->id) . '" class="btn btn-success" title="Berkas guru">
                                <i class="fas fa-image"></i>
                            </a>
                            <a href="#" class="btn btn-secondary" title="Cetak Berkas">
                                <i class="fas fa-print"></i>
                            </a>
                            <button class="btn btn-danger btnHapus" title="Hapus" data-id="' . $row->id . '"> 
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        ';
                return $btn;
            })
            ->rawColumns(['action', 'stats'])
            ->make(true);
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $data = $request->all();

            foreach ($data as $key => $value) {
                if ($value === '') {
                    $data[$key] = null;
                }
            }

            $guru = Guru::create($data);

            Gurukeluarga::create([
                'guru_id' => $guru->id,
            ]);

            PendidikanGuru::create([
                'guru_id' => $guru->id,
            ]);

            PenugasanGuru::create([
                'guru_id' => $guru->id,
            ]);

            return $guru->id;
        });
    }

    public function editstep1($id, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $guru = Guru::findOrFail($id);
        $agama = Agama::all();
        $jurusan = Jurusan::all();
        $provinsi = Provinsi::all();
        $title = 'Guru';
        return view('admin.guru.step1', compact('guru', 'agama', 'jurusan', 'provinsi', 'st', 'user', 'title'));
    }

    public function updateStep1(Request $request, $id)
    {
        try {
            $guru = Guru::findOrFail($id);

            $guru->update([
                'nama' => strtoupper($request->nama),
                'nik' => $request->nik,
                'nip' => $request->nip,
                'nuptk' => $request->nuptk,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => strtoupper($request->tempat_lahir),
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama_id' => $request->agama,
                'jurusan_id' => $request->jurusan,
                'jenis_gtk' => $request->jenis_gtk,
                'jabatan_gtk' => $request->jabatan_gtk,
                'status_perkawinan' => $request->status_perkawinan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => strtoupper($request->alamat),
                'pos' => $request->pos,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'kec' => $request->kec,
                'desa' => $request->desa,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Step 1 berhasil tersimpan',
                'id' => $id,
                'st' => $request->st
            ]);
        } catch (\Throwable $th) {
            return back()
                ->with('error', 'Gagal menyimpan Step 1')
                ->withInput();
        }
    }

    public function editstep2($id, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $guru = Guru::findOrFail($id);
        $title = 'Guru';
        return view('admin.guru.step2', compact('guru', 'st', 'user', 'title'));
    }

    public function batal(Request $request)
    {
        $id = $request->id;
        $guru = Guru::findOrFail($id);

        $guru->delete();

        return response()->json(['success' => true]);
    }
}
