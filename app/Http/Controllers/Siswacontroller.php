<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Desa;
use App\Models\Jurusan;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\Provinsi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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

    public function siswa_data(Request $request)
    {
        $query = Siswa::query()->whereNotNull('nis')->where('nis', '!=', '');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->orderBy('id_person', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                        <div class="d-flex gap-1">
                            <a href="' . route('siswa.show', $row) . '" class="btn btn-info" title="Detail Siswa">
                                <i class="fas fa-info"></i>
                            </a>
                            <a href="' . route('siswa.edit.step1', [$row, 'e']) . '" class="btn btn-warning" title="Edit Siswa">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="' . route('siswa.upload', $row) . '" class="btn btn-success" title="Berkas Siswa">
                                <i class="fas fa-image"></i>
                            </a>
                            <a href="' . route('siswa.print', $row) . '" target="_blank" class="btn btn-secondary" title="Cetak Berkas">
                                <i class="fas fa-print"></i>
                            </a>
                            <button class="btn btn-danger btnHapus" title="Hapus" data-id="' . $row->getRouteKey() . '"> 
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        ';
                return $btn;
            })
            ->addColumn('stats', function ($row) {
                $status = '';
                if ($row->status == 'Aktif') {
                    $status = '<span class="badge badge-primary-light">Aktif</span>';
                } elseif ($row->status == 'Lulus') {
                    $status = '<span class="badge badge-success-light">Lulus</span>';
                } elseif ($row->status == 'Pindah') {
                    $status = '<span class="badge badge-warning-light">Mutasi Keluar</span>';
                } elseif ($row->status == 'Keluar') {
                    $status = '<span class="badge badge-danger-light">Berhenti</span>';
                }
                return $status;
            })
            ->rawColumns(['action', 'stats'])
            ->make(true);
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
        return $siswa->getRouteKey();
    }

    public function get_kabupaten($provinsi_id)
    {
        $kabupaten = Kabupaten::where('province_id', $provinsi_id)->get();
        return response()->json($kabupaten);
    }

    public function get_kecamatan($kabupaten_id)
    {
        $kecamatan = Kecamatan::where('regency_id', $kabupaten_id)->get();
        return response()->json($kecamatan);
    }

    public function get_desa($kecamatan_id)
    {
        $desa = Desa::where('district_id', $kecamatan_id)->get();
        return response()->json($desa);
    }

    public function editstep1(Siswa $siswa, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $agama = Agama::all();
        $jurusan = Jurusan::all();
        $title = 'Siswa';
        return view('admin.siswa.step1', compact('siswa', 'agama', 'jurusan', 'st', 'user', 'title'));
    }

    public function updateStep1(Request $request, Siswa $siswa)
    {
        try {
            $siswa->update([
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
                'id_person' => $siswa->getRouteKey(),
                'st' => $request->st
            ]);
        } catch (\Throwable $th) {
            return back()
                ->with('error', 'Gagal menyimpan Step 1')
                ->withInput();
        }
    }

    public function editstep2(Siswa $siswa, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $provinsi = Provinsi::all();
        $title = 'Siswa';
        return view('admin.siswa.step2', compact('siswa', 'provinsi', 'st', 'user', 'title'));
    }

    public function updateStep2(Request $request, Siswa $siswa)
    {
        $request->validate([
            'kewarganegaraan' => 'required',
            'alamat_lengkap' => 'required',
            'prov' => 'required',
            'kab' => 'required',
            'kec' => 'required',
            'desa' => 'required',
        ]);

        try {

            $siswa->update([
                'kewarganegaraan' => $request->kewarganegaraan,
                'alamat_lengkap' => strtoupper($request->alamat_lengkap),
                'prov' => $request->prov,
                'kab' => $request->kab,
                'kec' => $request->kec,
                'desa' => $request->desa,
                'pos' => $request->pos,
                'status_step' => 2,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Step 2 berhasil tersimpan',
                'id_person' => $siswa->getRouteKey(),
                'st' => $request->st
            ]);
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Gagal menyimpan Step 2')
                ->withInput();
        }
    }

    public function editstep3(Siswa $siswa, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $pekerjaan = Pekerjaan::all();
        $pendidikan = Pendidikan::all();
        $penghasilan = Penghasilan::all();
        $agama = Agama::all();
        $title = 'Siswa';
        // proteksi step
        if ($siswa->status_step < 2) {
            return redirect()->route('siswa.edit.step2', [$siswa, $st]);
        }
        return view('admin.siswa.step3', compact('siswa', 'pekerjaan', 'pendidikan', 'penghasilan', 'agama', 'st', 'user', 'title'));
    }

    public function updateStep3(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nik_a' => 'required',
            'nm_a' => 'required',
            'tgl_lahir_a' => 'required',
            'tmpt_lahir_a' => 'required',
            'agama_a' => 'required',
            'pkrjn_a' => 'required',
            'pndkn_a' => 'required',
            'penghasilan_a' => 'required',

            'nik_i' => 'required',
            'nm_i' => 'required',
            'tgl_lahir_i' => 'required',
            'tmpt_lahir_i' => 'required',
            'agama_i' => 'required',
            'pkrjn_i' => 'required',
            'pndkn_i' => 'required',
            'penghasilan_i' => 'required'
        ]);

        try {
            $siswa->update([
                'nik_a' => $request->nik_a,
                'nm_a' => strtoupper($request->nm_a),
                'tgl_lahir_a' => $request->tgl_lahir_a,
                'tmpt_lahir_a' => strtoupper($request->tmpt_lahir_a),
                'agama_a' => $request->agama_a,
                'pkrjn_a' => $request->pkrjn_a,
                'pndkn_a' => $request->pndkn_a,
                'penghasilan_a' => $request->penghasilan_a,

                'nik_i' => $request->nik_i,
                'nm_i' => strtoupper($request->nm_i),
                'tgl_lahir_i' => $request->tgl_lahir_i,
                'tmpt_lahir_i' => strtoupper($request->tmpt_lahir_i),
                'agama_i' => $request->agama_i,
                'pkrjn_i' => $request->pkrjn_i,
                'pndkn_i' => $request->pndkn_i,
                'penghasilan_i' => $request->penghasilan_i,

                'status_step' => 3,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Step 3 berhasil tersimpan',
                'id_person' => $siswa->getRouteKey(),
                'st' => $request->st
            ]);
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Gagal menyimpan Step 3')
                ->withInput();
        }
    }

    public function editstep4(Siswa $siswa, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $pekerjaan = Pekerjaan::all();
        $pendidikan = Pendidikan::all();
        $penghasilan = Penghasilan::all();
        $agama = Agama::all();
        $provinsi = Provinsi::all();
        $title = 'Siswa';
        // proteksi step
        if ($siswa->status_step < 3) {
            return redirect()->route('siswa.edit.step3', [$siswa, $st]);
        }
        return view('admin.siswa.step4', compact('siswa', 'pekerjaan', 'pendidikan', 'penghasilan', 'agama', 'provinsi', 'st', 'user', 'title'));
    }

    public function updateStep4(Request $request, Siswa $siswa)
    {
        $jurusan = Jurusan::findOrFail($siswa->jurusan_id);

        $nomorUmum = Siswa::whereNotNull('nis')->count() + 1;

        $nomorJurusan = Siswa::where('jurusan_id', $jurusan->id)
            ->where('id_person', '!=', $siswa->id_person)
            ->count() + 1;

        $A = str_pad($nomorUmum, 4, '0', STR_PAD_LEFT);
        $B = str_pad($nomorJurusan, 3, '0', STR_PAD_LEFT);

        // C = kode jurusan
        $C = $jurusan->kode_nomenklatur;

        $nis = "{$A}/{$B}.{$C}";

        $request->validate([
            'nm_w' => 'required',
            'nik_w' => 'required',
            'tmpt_lahir_w' => 'required',
            'tgl_lahir_w' => 'required',
            'agama_w' => 'required',
            'pkrjn_w' => 'required',
            'pndkn_w' => 'required',
            'penghasilan_w' => 'required',
            'almt_w' => 'required',
            'desa_w' => 'required',
            'kec_w' => 'required',
            'kab_w' => 'required',
            'prov_w' => 'required',
            'pos_w' => 'required',
        ]);

        try {
            if ($request->st == 't') {
                $siswa->update([
                    'nis' => $nis,
                    'nm_w' => strtoupper($request->nm_w),
                    'nik_w' => $request->nik_w,
                    'tmpt_lahir_w' => strtoupper($request->tmpt_lahir_w),
                    'tgl_lahir_w' => $request->tgl_lahir_w,
                    'agama_w' => $request->agama_w,
                    'pkrjn_w' => $request->pkrjn_w,
                    'pndkn_w' => $request->pndkn_w,
                    'penghasilan_w' => $request->penghasilan_w,
                    'hp_w' => $request->hp_w,
                    'almt_w' => strtoupper($request->almt_w),
                    'desa_w' => $request->desa_w,
                    'kec_w' => $request->kec_w,
                    'kab_w' => $request->kab_w,
                    'prov_w' => $request->prov_w,
                    'pos_w' => $request->pos_w,
                    'tgl_daftar' => now(),
                    'user_id' => Auth::id(),
                    'status' => "Aktif",
                    'status_step' => 4,
                ]);
            } else {
                $siswa->update([
                    'nm_w' => strtoupper($request->nm_w),
                    'nik_w' => $request->nik_w,
                    'tmpt_lahir_w' => strtoupper($request->tmpt_lahir_w),
                    'tgl_lahir_w' => $request->tgl_lahir_w,
                    'agama_w' => $request->agama_w,
                    'pkrjn_w' => $request->pkrjn_w,
                    'pndkn_w' => $request->pndkn_w,
                    'penghasilan_w' => $request->penghasilan_w,
                    'hp_w' => $request->hp_w,
                    'almt_w' => strtoupper($request->almt_w),
                    'desa_w' => $request->desa_w,
                    'kec_w' => $request->kec_w,
                    'kab_w' => $request->kab_w,
                    'prov_w' => $request->prov_w,
                    'pos_w' => $request->pos_w,
                    'status_step' => 4,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Step 4 berhasil tersimpan',
                'id_person' => $siswa->getRouteKey(),
                'st' => $request->st
            ]);
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Gagal menyimpan data wali')
                ->withInput();
        }
    }

    public function batal(Request $request)
    {
        $decoded = \Hashids::decode($request->id);
        if (empty($decoded)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid.']);
        }
        $siswa = Siswa::findOrFail($decoded[0]);

        $siswa->delete();

        return response()->json(['success' => true]);
    }

    public function show(Siswa $siswa)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Siswa';

        return view('admin.siswa.show', compact('title', 'user', 'siswa'));
    }

    public function print(Siswa $siswa)
    {
        $siswa->load([
            'agama',
            'jurusan',
            'agamaAyah',
            'pekerjaanAyah',
            'pendidikanAyah',
            'penghasilanAyah',
            'agamaIbu',
            'pekerjaanIbu',
            'pendidikanIbu',
            'penghasilanIbu',
            'agamaWali',
            'pekerjaanWali',
            'pendidikanWali',
            'penghasilanWali',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desa'
        ]);

        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Fetch student's active rombel assignment
        $placement = \App\Models\PenempatanRombel::where('siswa_id', $siswa->id_person)
            ->where('status_aktif', 1)
            ->with('rombel.kelas')
            ->first();

        // Resolve wali address details
        $wali_address_details = [
            'desa' => $siswa->desa_w ? (\App\Models\Desa::find($siswa->desa_w)->name ?? '') : '',
            'kec' => $siswa->kec_w ? (\App\Models\Kecamatan::find($siswa->kec_w)->name ?? '') : '',
            'kab' => $siswa->kab_w ? (\App\Models\Kabupaten::find($siswa->kab_w)->name ?? '') : '',
            'prov' => $siswa->prov_w ? (\App\Models\Provinsi::find($siswa->prov_w)->name ?? '') : '',
        ];

        return view('admin.siswa.print', compact('siswa', 'placement', 'wali_address_details'));
    }

    public function upload(Siswa $siswa)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Siswa';

        return view('admin.siswa.upload', compact('title', 'user', 'siswa'));
    }

    public function updateUpload(Request $request, Siswa $siswa)
    {
        $rules = [
            'foto_warna_santri' => ($siswa->foto_warna_santri ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'foto_scan_kk' => ($siswa->foto_scan_kk ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'foto_scan_akta' => ($siswa->foto_scan_akta ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'foto_scan_skck' => ($siswa->foto_scan_skck ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'foto_scan_ket_sehat' => ($siswa->foto_scan_ket_sehat ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ijazah' => ($siswa->foto_ijazah ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [
            'required' => ':attribute wajib diunggah.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berformat JPG, JPEG, atau PNG.',
            'max' => 'Ukuran :attribute maksimal 2 MB.',
        ];

        $attributes = [
            'foto_warna_santri' => 'Foto Siswa',
            'foto_scan_kk' => 'Foto Scan KK',
            'foto_scan_akta' => 'Foto Scan Akta Lahir',
            'foto_scan_skck' => 'Foto Scan SKCK',
            'foto_scan_ket_sehat' => 'Foto Scan Surat Ket Sehat',
            'foto_ijazah' => 'Foto Scan Ijazah',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $updateData = [];
            $destinationPath = public_path('gambar_berkas/berkas_siswa');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fields = [
                'foto_warna_santri',
                'foto_scan_kk',
                'foto_scan_akta',
                'foto_scan_skck',
                'foto_scan_ket_sehat',
                'foto_ijazah'
            ];

            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $field . '_' . $siswa->id_person . '_' . time() . '.' . $file->getClientOriginalExtension();

                    // Delete old file if it exists
                    if ($siswa->$field && file_exists($destinationPath . '/' . $siswa->$field)) {
                        @unlink($destinationPath . '/' . $siswa->$field);
                    }

                    // Move new file to public/gambar_berkas
                    $file->move($destinationPath, $filename);
                    $updateData[$field] = $filename;
                }
            }

            if (!empty($updateData)) {
                $siswa->update($updateData);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berkas berhasil diunggah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah berkas: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadBerkas(Siswa $siswa, $field)
    {
        $fileName = $siswa->$field;
        if (!$fileName) {
            abort(404, 'Berkas tidak ditemukan');
        }

        $filePath = public_path('gambar_berkas/berkas_siswa/' . $fileName);
        if (!file_exists($filePath)) {
            abort(404, 'Berkas fisik tidak ditemukan');
        }

        // Clean student name
        $cleanStudentName = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $siswa->nama));

        // Clean field name for dynamic naming
        $cleanField = 'Berkas';
        if ($field === 'foto_scan_kk') {
            $cleanField = 'Kartu_Keluarga';
        } elseif ($field === 'foto_scan_akta') {
            $cleanField = 'Akta_Kelahiran';
        } elseif ($field === 'foto_ijazah') {
            $cleanField = 'Ijazah';
        } elseif ($field === 'foto_scan_skck') {
            $cleanField = 'SKCK';
        } elseif ($field === 'foto_scan_ket_sehat') {
            $cleanField = 'Surat_Sehat';
        } elseif ($field === 'foto_warna_santri') {
            $cleanField = 'Foto_Siswa';
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = $cleanField . '_' . $cleanStudentName . '.' . $extension;

        return response()->download($filePath, $downloadName);
    }

    public function hapus(Request $request)
    {
        $decoded = \Hashids::decode($request->id);
        if (empty($decoded)) {
            return response()->json(['status' => 'error', 'message' => 'ID tidak valid.']);
        }
        Siswa::where('id_person', $decoded[0])->update([
            'status' => 'Keluar'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data siswa berhasil dihapus.']);
    }
}
