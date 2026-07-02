<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use App\Models\Guru;
use App\Models\Agama;
use App\Models\Provinsi;
use App\Models\Pekerjaan;
use App\Models\Gurukeluarga;
use App\Models\PendidikanGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruPortalController extends Controller
{
    /**
     * Display the teacher dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        // Redirect to show page if profile completion is already finished
        if ($guru && $guru->nik !== null && $guru->jenis_gtk !== null) {
            return redirect()->route('guru.lengkapi_data.show');
        }

        $title = 'Dashboard';
        $periodeAktif = Periode::where('status', 1)->first();
        return view('guru.dashboard', compact('title', 'periodeAktif', 'user', 'guru'));
    }

    /**
     * Display the teacher profile view.
     */
    public function profile()
    {
        $title = 'Pengaturan Profil';
        $user = Auth::user();
        return view('guru.profile.index', compact('title', 'user'));
    }

    /**
     * Update the teacher's profile photo.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi Anda telah berakhir.'
            ], 403);
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'photo.required' => 'Foto profil wajib dipilih.',
            'photo.image' => 'Foto profil harus berupa file gambar.',
            'photo.mimes' => 'Foto profil harus berformat JPG, JPEG, atau PNG.',
            'photo.max' => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        try {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $destinationPath = public_path('gambar_berkas/avatars');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $filename = 'avatar_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Delete old photo if it exists and is not default
                if ($user->photo && file_exists($destinationPath . '/' . $user->photo)) {
                    @unlink($destinationPath . '/' . $user->photo);
                }

                // Move file
                $file->move($destinationPath, $filename);

                // Update photo in users table
                User::where('id', $user->id)->update(['photo' => $filename]);

                // Update photo in guru table
                Guru::where('email', $user->email)->update(['foto' => $filename]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Foto profil berhasil diperbarui!'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada file foto profil yang diupload.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui foto profil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the teacher's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi Anda telah berakhir.'
            ], 403);
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password saat ini salah.'
            ], 422);
        }

        try {
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui password: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display step 1 of biodata completion.
     */
    public function lengkapiStep1()
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        // Redirection logic based on completion: only redirect to show if fully completed
        if ($guru->nik !== null && $guru->jenis_gtk !== null) {
            return redirect()->route('guru.lengkapi_data.show');
        }

        $agama = Agama::all();
        $provinsi = Provinsi::all();
        $gurukeluarga = Gurukeluarga::where('guru_id', $guru->id)->first();
        $pekerjaan = Pekerjaan::all();
        
        $title = 'Lengkapi Biodata - Langkah 1';
        $st = 'e'; // default to edit

        return view('guru.lengkapi data.step1', compact('guru', 'pekerjaan', 'gurukeluarga', 'agama', 'provinsi', 'st', 'user', 'title'));
    }

    /**
     * Update step 1 of biodata completion.
     */
    public function updateLengkapiStep1(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id . '|unique:guru,email,' . $guru->id,
            'nama' => 'required',
        ], [
            'email.unique' => 'Alamat email sudah digunakan oleh pengguna lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        DB::beginTransaction();

        try {
            $guru->update([
                'nama' => strtoupper($request->nama),
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nik' => $request->nik,
                'niy' => $request->niy,
                'nuptk' => $request->nuptk,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => strtoupper($request->tempat_lahir),
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama_id' => $request->agama,
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

            // Update user email and name to keep it synced
            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            // Cari data keluarga, jika belum ada maka buat baru
            Gurukeluarga::updateOrCreate(
                [
                    'guru_id' => $guru->id
                ],
                [
                    'nama_ibu' => strtoupper($request->nama_ibu),
                    'nama_pasangan' => $request->status_perkawinan == 'kawin'
                        ? strtoupper($request->nama_pasangan)
                        : null,
                    'pekerjaan_pasangan' => $request->status_perkawinan == 'kawin'
                        ? $request->pekerjaan_pasangan
                        : null,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Step 1 berhasil tersimpan',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data step 1',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display step 2 of biodata completion.
     */
    public function lengkapiStep2()
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        // Redirection logic
        if ($guru->nik === null) {
            return redirect()->route('guru.lengkapi_data.step1');
        }
        if ($guru->jenis_gtk !== null) {
            return redirect()->route('guru.lengkapi_data.show');
        }

        $title = 'Lengkapi Biodata - Langkah 2';
        $st = 'e';

        return view('guru.lengkapi data.step2', compact('guru', 'st', 'user', 'title'));
    }

    /**
     * Update step 2 of biodata completion.
     */
    public function updateLengkapiStep2(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $guru->update([
                'jenis_gtk' => $request->jenis_gtk,
                'jabatan_gtk' => $request->jabatan_gtk,
                'status_kepegawaian' => $request->status_kepegawaian,
                'sk_pengangkatan' => strtoupper($request->sk_pengangkatan),
                'tmt_pengangkatan' => $request->tmt_pengangkatan,
                'lembaga_pengangkat' => strtoupper($request->lembaga_pengangkat),
                'npwp' => $request->npwp,
                'nama_wajib_pajak' => $request->nama_wajib_pajak,
                'status_kuliah' => $request->status_kuliah,
                'no_surat_tugas' => strtoupper($request->no_surat_tugas),
                'tgl_surat_tugas' => $request->tgl_surat_tugas,
                'tahun_pensiun' => $request->tahun_pensiun,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Step 2 berhasil tersimpan',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data step 2',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the final biodata detail view.
     */
    public function lengkapiShow()
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        // Redirection logic: if incomplete, redirect to correct step
        if ($guru->nik === null) {
            return redirect()->route('guru.lengkapi_data.step1');
        }
        if ($guru->jenis_gtk === null) {
            return redirect()->route('guru.lengkapi_data.step2');
        }

        $guru->load(['keluarga', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'desaDetail', 'agama']);
        $title = 'Detail Biodata';

        return view('guru.lengkapi data.show', compact('title', 'user', 'guru'));
    }

    /**
     * Display upload documents page.
     */
    public function lengkapiUpload()
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        $title = 'Unggah Berkas';

        return view('guru.lengkapi data.upload', compact('title', 'user', 'guru'));
    }

    /**
     * Update/upload teacher documents.
     */
    public function updateLengkapiUpload(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        $rules = [
            'foto' => ($guru->foto ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'scan_kk' => ($guru->scan_kk ? 'nullable' : 'required') . '|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_akta' => ($guru->scan_akta ? 'nullable' : 'required') . '|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_ktp' => ($guru->scan_ktp ? 'nullable' : 'required') . '|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_sk' => ($guru->scan_sk ? 'nullable' : 'required') . '|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_transkrip_nilai' => ($guru->scan_transkrip_nilai ? 'nullable' : 'required') . '|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];

        $messages = [
            'required' => ':attribute wajib diunggah.',
            'image' => ':attribute harus berupa gambar.',
            'file' => ':attribute harus berupa berkas.',
            'mimes' => ':attribute harus berformat JPG, JPEG, PNG, atau PDF.',
            'max' => 'Ukuran :attribute maksimal 2 MB.',
        ];

        $attributes = [
            'foto' => 'Foto Guru',
            'scan_kk' => 'Scan KK',
            'scan_akta' => 'Scan Akta Lahir',
            'scan_ktp' => 'Scan KTP',
            'scan_sk' => 'Scan SK',
            'scan_transkrip_nilai' => 'Scan Transkrip Nilai',
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
            $destinationPath = public_path('gambar_berkas/berkas_guru');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fields = [
                'foto',
                'scan_kk',
                'scan_akta',
                'scan_ktp',
                'scan_sk',
                'scan_transkrip_nilai'
            ];

            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $field . '_' . $guru->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                    // Delete old file if it exists
                    if ($guru->$field && file_exists($destinationPath . '/' . $guru->$field)) {
                        @unlink($destinationPath . '/' . $guru->$field);
                    }

                    // Move new file to public/gambar_berkas/berkas_guru
                    $file->move($destinationPath, $filename);
                    $updateData[$field] = $filename;
                }
            }

            if (!empty($updateData)) {
                $guru->update($updateData);
                // NOTE: We explicitly DO NOT update $user->photo, keeping it isolated.
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berkas berhasil diunggah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah berkas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store education history for the logged-in teacher.
     */
    public function storePendidikan(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        // Force guru_id to match the logged-in teacher's ID
        $request->merge(['guru_id' => $guru->id]);

        $rules = [
            'guru_id' => 'required|exists:guru,id',
            'jenjang' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'required|digits:4',
            'tahun_lulus' => 'required|digits:4',
            'nomor_ijazah' => 'nullable|string|max:255',
            'scan_file_ijazah' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'digits' => ':attribute harus berupa 4 digit tahun.',
            'mimes' => ':attribute harus berformat JPG, JPEG, PNG, atau PDF.',
            'max' => 'Ukuran :attribute maksimal 2 MB.',
        ];

        $attributes = [
            'jenjang' => 'Jenjang',
            'nama_instansi' => 'Nama Instansi',
            'jurusan' => 'Jurusan',
            'tahun_masuk' => 'Tahun Masuk',
            'tahun_lulus' => 'Tahun Lulus',
            'nomor_ijazah' => 'Nomor Ijazah',
            'scan_file_ijazah' => 'Scan Ijazah',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $data = $request->except('scan_file_ijazah');
            $data['nama_instansi'] = strtoupper($request->nama_instansi);
            if ($request->filled('jurusan')) {
                $data['jurusan'] = strtoupper($request->jurusan);
            }

            if ($request->hasFile('scan_file_ijazah')) {
                $file = $request->file('scan_file_ijazah');
                $filename = 'ijazah_' . $request->jenjang . '_' . $request->guru_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('gambar_berkas/berkas_guru');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $data['scan_file_ijazah'] = $filename;
            }

            PendidikanGuru::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Riwayat pendidikan berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan riwayat pendidikan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download education ijazah scan for the logged-in teacher.
     */
    public function downloadPendidikanBerkas($id)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();
        if (!$guru) {
            abort(403, 'Unauthorized');
        }

        $pendidikan = PendidikanGuru::findOrFail($id);
        if ($pendidikan->guru_id !== $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke berkas ini.');
        }

        $fileName = $pendidikan->scan_file_ijazah;
        if (!$fileName) {
            abort(404, 'Berkas tidak ditemukan');
        }

        $filePath = public_path('gambar_berkas/berkas_guru/' . $fileName);
        if (!file_exists($filePath)) {
            abort(404, 'Berkas fisik tidak ditemukan');
        }

        $cleanName = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $guru->nama));
        $cleanField = 'Ijazah_' . $pendidikan->jenjang;
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = $cleanField . '_' . $cleanName . '.' . $extension;

        return response()->download($filePath, $downloadName);
    }

    /**
     * Download profile document file for the logged-in teacher.
     */
    public function downloadBerkas($field)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();
        if (!$guru) {
            abort(403, 'Unauthorized');
        }

        $validFields = ['foto', 'scan_kk', 'scan_akta', 'scan_ktp', 'scan_sk', 'scan_transkrip_nilai'];
        if (!in_array($field, $validFields)) {
            abort(400, 'Field tidak valid');
        }

        $fileName = $guru->$field;
        if (!$fileName) {
            abort(404, 'Berkas tidak ditemukan');
        }

        $filePath = public_path('gambar_berkas/berkas_guru/' . $fileName);
        if (!file_exists($filePath)) {
            abort(404, 'Berkas fisik tidak ditemukan');
        }

        $cleanName = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $guru->nama));

        $cleanField = 'Berkas';
        if ($field === 'scan_kk') {
            $cleanField = 'Kartu_Keluarga';
        } elseif ($field === 'scan_akta') {
            $cleanField = 'Akta_Kelahiran';
        } elseif ($field === 'scan_ktp') {
            $cleanField = 'KTP';
        } elseif ($field === 'scan_sk') {
            $cleanField = 'SK';
        } elseif ($field === 'scan_transkrip_nilai') {
            $cleanField = 'Transkrip_Nilai';
        } elseif ($field === 'foto') {
            $cleanField = 'Foto_Guru';
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = $cleanField . '_' . $cleanName . '.' . $extension;

        return response()->download($filePath, $downloadName);
    }
}
