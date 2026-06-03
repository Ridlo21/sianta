<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Jurusan;
use App\Models\Provinsi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Siswacontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Siswa';

        return view('admin.siswa.index', compact('title', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }
        $siswa = Siswa::create($data);
        $id = $siswa->id_person;
        return $id;
    }

    public function editstep1($id, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $siswa = Siswa::findOrFail($id);
        $agama = Agama::all();
        $jurusan = Jurusan::all();
        $title = 'Siswa';
        return view('admin.siswa.step1', compact('siswa', 'agama', 'jurusan', 'st', 'user', 'title'));
    }

    public function updateStep1(Request $request, $id)
    {
        try {
            $murid = Siswa::findOrFail($id);

            $murid->update([
                'nama' => strtoupper($request->nama),
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'no_akta' => $request->no_akta,
                'nisn' => $request->nisn,
                'niup' => $request->niup,
                'tempat_lahir' => strtoupper($request->tempat_lahir),
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama_id' => $request->agama,
                'dlm_klrg' => $request->dlm_klrg,
                'ank_ke' => $request->ank_ke,
                'sdr' => $request->sdr,
                'jurusan_id' => $request->jurusan,
                'jenis_daftar' => $request->jenis_daftar,
                'asal_sekolah' => strtoupper($request->asal_sekolah),
                'nomor_ijazah' => $request->nomor_ijazah,
                'tinggal_di' => $request->tinggal_di,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'hoby' => strtoupper($request->hoby),
                'cita_cita' => strtoupper($request->cita_cita),
                'niup' => $request->niup,
                'status_step' => 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Step 1 berhasil tersimpan',
                'id_person' => $id,
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
        $siswa = Siswa::findOrFail($id);
        $provinsi = Provinsi::all();
        $title = 'Siswa';
        return view('admin.siswa.step2', compact('siswa', 'provinsi', 'st', 'user', 'title'));
    }



    public function batal(Request $request)
    {
        $id = $request->id;
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return response()->json(['success' => true]);
    }
}
