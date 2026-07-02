<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\Gurukeluarga;
use App\Models\Jurusan;
use App\Models\Pekerjaan;
use App\Models\PendidikanGuru;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Gurucontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru & Tendik';

        return view('admin.guru.index', compact('title', 'user'));
    }

    public function guru_data()
    {
        $guru = Guru::where('status_aktif', '1')
        ->whereNotNull('jenis_gtk')
        ->orderBy('id', 'desc')
        ->get();

        return DataTables::of($guru)
            ->addIndexColumn()
            ->editColumn('nama', function ($row) {
                return $row->nama_lengkap;
            })
            ->addColumn('action', function ($row) {
                $btn = '
                        <div class="d-flex gap-1">
                            <a href="' . route('guru.show', $row) . '" class="btn btn-info" title="Detail guru">
                                <i class="fas fa-info"></i>
                            </a>
                            <a href="' . route('guru.edit.step1', [$row, 'e']) . '" class="btn btn-warning" title="Edit guru">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="' . route('guru.upload', $row) . '" class="btn btn-success" title="Berkas guru">
                                <i class="fas fa-image"></i>
                            </a>
                            <a href="' . route('guru.download.zip', $row) . '" class="btn btn-primary" title="Unduh Semua Berkas (ZIP)">
                                <i class="fas fa-file-archive"></i>
                            </a>
                            <a href="' . route('guru.print', $row) . '" target="_blank" class="btn btn-secondary" title="Cetak Berkas">
                                <i class="fas fa-print"></i>
                            </a>
                            <button class="btn btn-danger btnHapus" title="Hapus" data-id="' . $row->getRouteKey() . '"> 
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        ';
                return $btn;
            })
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->rawColumns(['action', 'stats', 'jenis_kelamin'])
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
            return $guru->getRouteKey();
        });
    }

    public function editstep1(Guru $guru, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $agama = Agama::all();
        $provinsi = Provinsi::all();
        $gurukeluarga = Gurukeluarga::where('guru_id', $guru->id)->first();
        $pekerjaan = Pekerjaan::all();
        $title = 'Guru & Tendik';
        return view('admin.guru.step1', compact('guru', 'pekerjaan', 'gurukeluarga', 'agama', 'provinsi', 'st', 'user', 'title'));
    }

    public function updateStep1(Request $request, Guru $guru)
    {
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
                'status_aktif' => $request->st == 't' ? 1 : $guru->status_aktif,
            ]);

            // Cari data keluarga, jika belum ada maka buat baru
            GuruKeluarga::updateOrCreate(
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
                'id' => $guru->getRouteKey(),
                'st' => $request->st
            ]);
        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data',
                'error' => $th->getMessage() // hapus saat production
            ], 500);
        }
    }

    public function editstep2(Guru $guru, $st)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru & Tendik';
        return view('admin.guru.step2', compact('guru', 'st', 'user', 'title'));
    }

    public function updateStep2(Request $request, Guru $guru)
    {
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
                'id' => $guru->getRouteKey(),
                'st' => $request->st
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

    public function batal(Request $request)
    {
        $decoded = \Hashids::decode($request->id);
        if (empty($decoded)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid.']);
        }
        $guru = Guru::findOrFail($decoded[0]);
        GuruKeluarga::where('guru_id', $guru->id)->delete();
        $guru->delete();

        return response()->json(['success' => true]);
    }

    public function show(Guru $guru)
    {
        $guru->load(['keluarga', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'desaDetail', 'agama']);
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru & Tendik';

        return view('admin.guru.show', compact('title', 'user', 'guru'));
    }

    public function downloadZip(Guru $guru)
    {
        $fields = [
            'foto' => 'Foto_Guru',
            'scan_kk' => 'Kartu_Keluarga',
            'scan_akta' => 'Akta_Kelahiran',
            'scan_ktp' => 'KTP',
            'scan_sk' => 'SK',
            'scan_transkrip_nilai' => 'Transkrip_Nilai'
        ];

        $filesToZip = [];
        foreach ($fields as $field => $label) {
            $fileName = $guru->$field;
            if ($fileName) {
                $filePath = public_path('gambar_berkas/berkas_guru/' . $fileName);
                if (file_exists($filePath)) {
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                    $filesToZip[$filePath] = $label . '.' . $extension;
                }
            }
        }

        if (empty($filesToZip)) {
            return back()->with('error', 'Tidak ada berkas yang diunggah untuk guru ini.');
        }

        $zipFileName = 'Berkas_' . str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $guru->nama)) . '_' . time() . '.zip';
        
        // Ensure temporary storage directory exists
        $tempDir = storage_path('app/public/temp_zips');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $zipPath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($filesToZip as $filePath => $localName) {
                $zip->addFile($filePath, $localName);
            }
            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function downloadBerkas(Guru $guru, $field)
    {
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

    public function storePendidikan(Request $request)
    {
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
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadPendidikanBerkas($id)
    {
        $pendidikan = PendidikanGuru::findOrFail($id);
        $fileName = $pendidikan->scan_file_ijazah;
        if (!$fileName) {
            abort(404, 'Berkas tidak ditemukan');
        }

        $filePath = public_path('gambar_berkas/berkas_guru/' . $fileName);
        if (!file_exists($filePath)) {
            abort(404, 'Berkas fisik tidak ditemukan');
        }

        $guru = Guru::findOrFail($pendidikan->guru_id);
        $cleanName = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $guru->nama));
        $cleanField = 'Ijazah_' . $pendidikan->jenjang;
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = $cleanField . '_' . $cleanName . '.' . $extension;

        return response()->download($filePath, $downloadName);
    }

    public function upload(Guru $guru)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru & Tendik';

        return view('admin.guru.upload', compact('title', 'user', 'guru'));
    }

    public function updateUpload(Request $request, Guru $guru)
    {
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

    public function print(Guru $guru)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $guru->load([
            'agama',
            'keluarga.pekerjaanPasangan',
            'pendidikan',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desaDetail'
        ]);

        $tahunAktif = \App\Models\TahunAjaran::where('status', '1')->first();
        $tahunAktifId = $tahunAktif ? $tahunAktif->id : null;

        // Active pembelajaran
        $activePembelajaran = $guru->pembelajaran()
            ->where('status_aktif', 1)
            ->whereHas('rombel', function ($q) use ($tahunAktifId) {
                if ($tahunAktifId) {
                    $q->where('tahun_ajaran_id', $tahunAktifId);
                }
            })
            ->with(['rombel.kelas', 'rombel.jurusan', 'mataPelajaran'])
            ->get();

        // Total teaching hours
        $totalJamMengajar = $activePembelajaran->sum('jam_mengajar');

        // Total students
        $uniqueRombelIds = $activePembelajaran->pluck('rombel_id')->unique();
        $totalSiswa = 0;
        if ($uniqueRombelIds->isNotEmpty()) {
            $totalSiswa = \App\Models\PenempatanRombel::whereIn('rombel_id', $uniqueRombelIds)
                ->where('status_aktif', 1)
                ->count();
        }

        // Education priority
        $jenjangPriority = [
            'S3' => 10,
            'S2' => 9,
            'S1' => 8,
            'D4' => 7,
            'D3' => 6,
            'D2' => 5,
            'D1' => 4,
            'SMA' => 3,
            'SMK' => 3,
            'MA' => 3,
            'SMP' => 2,
            'MTS' => 2,
            'SD' => 1,
            'MI' => 1,
        ];
        
        $highestPendidikan = $guru->pendidikan->sortByDesc(function ($p) use ($jenjangPriority) {
            $priority = $jenjangPriority[strtoupper($p->jenjang)] ?? 0;
            return [$priority, (int)$p->tahun_lulus];
        })->first();

        $pendidikanTerakhir = $highestPendidikan 
            ? ($highestPendidikan->jenjang . ($highestPendidikan->jurusan ? ' - ' . $highestPendidikan->jurusan : ''))
            : '-';

        // Get the active principal (kepala sekolah)
        $kepalaSekolah = Guru::where('status_aktif', '1')
            ->where(function ($q) {
                $q->where('jabatan_gtk', 'Kepala Sekolah')
                  ->orWhere('jenis_gtk', 'Kepala Sekolah');
            })
            ->first();

        return view('admin.guru.print', compact(
            'guru', 
            'tahunAktif', 
            'activePembelajaran', 
            'totalJamMengajar', 
            'totalSiswa', 
            'pendidikanTerakhir',
            'kepalaSekolah'
        ));
    }

    public function publicProfile(Guru $guru)
    {
        $guru->load([
            'agama',
            'pendidikan',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desaDetail'
        ]);

        $tahunAktif = \App\Models\TahunAjaran::where('status', '1')->first();
        $tahunAktifId = $tahunAktif ? $tahunAktif->id : null;

        // Active pembelajaran
        $activePembelajaran = $guru->pembelajaran()
            ->where('status_aktif', 1)
            ->whereHas('rombel', function ($q) use ($tahunAktifId) {
                if ($tahunAktifId) {
                    $q->where('tahun_ajaran_id', $tahunAktifId);
                }
            })
            ->with(['rombel.kelas', 'rombel.jurusan', 'mataPelajaran'])
            ->get();

        // Total teaching hours
        $totalJamMengajar = $activePembelajaran->sum('jam_mengajar');

        // Education priority
        $jenjangPriority = [
            'S3' => 10,
            'S2' => 9,
            'S1' => 8,
            'D4' => 7,
            'D3' => 6,
            'D2' => 5,
            'D1' => 4,
            'SMA' => 3,
            'SMK' => 3,
            'MA' => 3,
            'SMP' => 2,
            'MTS' => 2,
            'SD' => 1,
            'MI' => 1,
        ];
        
        $highestPendidikan = $guru->pendidikan->sortByDesc(function ($p) use ($jenjangPriority) {
            $priority = $jenjangPriority[strtoupper($p->jenjang)] ?? 0;
            return [$priority, (int)$p->tahun_lulus];
        })->first();

        $pendidikanTerakhir = $highestPendidikan 
            ? ($highestPendidikan->jenjang . ($highestPendidikan->jurusan ? ' - ' . $highestPendidikan->jurusan : ''))
            : '-';

        return view('admin.guru.public_profile', compact(
            'guru', 
            'tahunAktif', 
            'activePembelajaran', 
            'totalJamMengajar', 
            'pendidikanTerakhir'
        ));
    }

    public function exportExcel($gender)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (!in_array($gender, ['Laki-laki', 'Perempuan'])) {
            abort(404);
        }

        $genderDb = $gender === 'Laki-laki' ? 'L' : 'P';
        $gurus = Guru::where('jenis_kelamin', $genderDb)
            ->where('status_aktif', '1')
            ->with(['agama', 'provinsi', 'kabupaten', 'kecamatan', 'desaDetail', 'keluarga.pekerjaanPasangan', 'pendidikan'])
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Title Row
        $titleText = 'DATA GURU ' . ($gender === 'Laki-laki' ? 'LAKI-LAKI' : 'PEREMPUAN') . ' SMKNAA';
        $sheet->setCellValue('A1', $titleText);
        $sheet->mergeCells('A1:AQ1'); // Merge 43 columns (A to AQ)
        
        $sheet->getStyle('A1')->getFont()->setName('Calibri')->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 2. Column Headers
        $headers = [
            // Guru
            'No', 'NIY', 'Gelar Depan', 'Nama Lengkap', 'Gelar Belakang', 'NUPTK', 'NIK',
            'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Status Perkawinan',
            'Alamat', 'Desa/Kelurahan', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi', 'Kode Pos',
            'Email', 'No. HP', 'Jenis GTK', 'Jabatan GTK', 'Status Kepegawaian', 'SK Pengangkatan',
            'TMT Pengangkatan', 'Lembaga Pengangkat', 'NPWP', 'Nama Wajib Pajak', 'Sekolah Induk',
            'Status Kuliah', 'No. Surat Tugas', 'Tgl. Surat Tugas', 'Status Aktif', 'Tahun Pensiun',
            // Keluarga
            'Nama Ibu Kandung', 'Nama Pasangan', 'Pekerjaan Pasangan',
            // Pendidikan Terakhir
            'Jenjang Pendidikan Terakhir', 'Jurusan Pendidikan Terakhir', 'Nama Instansi Pendidikan Terakhir',
            'Tahun Masuk Pendidikan Terakhir', 'Tahun Lulus Pendidikan Terakhir', 'Nomor Ijazah Pendidikan Terakhir'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $col++;
        }

        // Style the Header
        $headerRange = 'A3:AQ3';
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF'); // Green background
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $jenjangPriority = [
            'S3' => 10, 'S2' => 9, 'S1' => 8, 'D4' => 7, 'D3' => 6, 'D2' => 5, 'D1' => 4,
            'SMA' => 3, 'SMK' => 3, 'MA' => 3, 'SMP' => 2, 'MTS' => 2, 'SD' => 1, 'MI' => 1
        ];

        // 3. Populate Data Rows
        $row = 4;
        foreach ($gurus as $index => $guru) {
            $lastEdu = $guru->pendidikan->sortByDesc(function ($p) use ($jenjangPriority) {
                $priority = $jenjangPriority[strtoupper($p->jenjang)] ?? 0;
                return [$priority, (int)$p->tahun_lulus];
            })->first();

            $desaName = $guru->desaDetail ? $guru->desaDetail->name : ($guru->desa ?? '-');
            $kecName = $guru->kecamatan ? $guru->kecamatan->name : ($guru->kec ?? '-');
            $kabName = $guru->kabupaten ? $guru->kabupaten->name : ($guru->kab ?? '-');
            $provName = $guru->provinsi ? $guru->provinsi->name : ($guru->prov ?? '-');

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValueExplicit('B' . $row, $guru->niy ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row, $guru->gelar_depan ?? '-');
            $sheet->setCellValue('D' . $row, $guru->nama ?? '-');
            $sheet->setCellValue('E' . $row, $guru->gelar_belakang ?? '-');
            $sheet->setCellValueExplicit('F' . $row, $guru->nuptk ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' . $row, $guru->nik ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('H' . $row, $guru->jenis_kelamin ?? '-');
            $sheet->setCellValue('I' . $row, $guru->tempat_lahir ?? '-');
            $sheet->setCellValue('J' . $row, $guru->tanggal_lahir ?? '-');
            $sheet->setCellValue('K' . $row, $guru->agama ? $guru->agama->nama_agama : '-');
            $sheet->setCellValue('L' . $row, $guru->status_perkawinan ?? '-');
            $sheet->setCellValue('M' . $row, $guru->alamat ?? '-');
            $sheet->setCellValue('N' . $row, $desaName);
            $sheet->setCellValue('O' . $row, $kecName);
            $sheet->setCellValue('P' . $row, $kabName);
            $sheet->setCellValue('Q' . $row, $provName);
            $sheet->setCellValueExplicit('R' . $row, $guru->pos ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('S' . $row, $guru->email ?? '-');
            $sheet->setCellValueExplicit('T' . $row, $guru->no_hp ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('U' . $row, $guru->jenis_gtk ?? '-');
            $sheet->setCellValue('V' . $row, $guru->jabatan_gtk ?? '-');
            $sheet->setCellValue('W' . $row, $guru->status_kepegawaian ?? '-');
            $sheet->setCellValue('X' . $row, $guru->sk_pengangkatan ?? '-');
            $sheet->setCellValue('Y' . $row, $guru->tmt_pengangkatan ?? '-');
            $sheet->setCellValue('Z' . $row, $guru->lembaga_pengangkat ?? '-');
            $sheet->setCellValueExplicit('AA' . $row, $guru->npwp ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('AB' . $row, $guru->nama_wajib_pajak ?? '-');
            $sheet->setCellValue('AC' . $row, $guru->sekolah_induk ?? '-');
            $sheet->setCellValue('AD' . $row, $guru->status_kuliah ?? '-');
            $sheet->setCellValueExplicit('AE' . $row, $guru->no_surat_tugas ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('AF' . $row, $guru->tgl_surat_tugas ?? '-');
            $sheet->setCellValue('AG' . $row, $guru->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif');
            $sheet->setCellValue('AH' . $row, $guru->tahun_pensiun ?? '-');

            // Keluarga (excluding kartu_pasangan)
            $pekerjaanPasangan = '-';
            if ($guru->keluarga) {
                if ($guru->keluarga->pekerjaanPasangan) {
                    $pekerjaanPasangan = $guru->keluarga->pekerjaanPasangan->nama_pekerjaan;
                } elseif ($guru->keluarga->pekerjaan_pasangan) {
                    $pekerjaanPasangan = $guru->keluarga->pekerjaan_pasangan;
                }
            }
            $sheet->setCellValue('AI' . $row, $guru->keluarga->nama_ibu ?? '-');
            $sheet->setCellValue('AJ' . $row, $guru->keluarga->nama_pasangan ?? '-');
            $sheet->setCellValue('AK' . $row, $pekerjaanPasangan);

            // Pendidikan Terakhir
            if ($lastEdu) {
                $sheet->setCellValue('AL' . $row, $lastEdu->jenjang ?? '-');
                $sheet->setCellValue('AM' . $row, $lastEdu->jurusan ?? '-');
                $sheet->setCellValue('AN' . $row, $lastEdu->nama_instansi ?? '-');
                $sheet->setCellValue('AO' . $row, $lastEdu->tahun_masuk ?? '-');
                $sheet->setCellValue('AP' . $row, $lastEdu->tahun_lulus ?? '-');
                $sheet->setCellValueExplicit('AQ' . $row, $lastEdu->nomor_ijazah ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            } else {
                $sheet->setCellValue('AL' . $row, 'belum dilengkapi');
                $sheet->setCellValue('AM' . $row, 'belum dilengkapi');
                $sheet->setCellValue('AN' . $row, 'belum dilengkapi');
                $sheet->setCellValue('AO' . $row, 'belum dilengkapi');
                $sheet->setCellValue('AP' . $row, 'belum dilengkapi');
                $sheet->setCellValue('AQ' . $row, 'belum dilengkapi');
            }

            $row++;
        }

        // Apply gridlines/borders to all populated cells
        $dataRange = 'A3:AQ' . ($row - 1);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // 4. Auto-fit columns
        foreach (range('A', 'Z') as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }
        foreach (['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ'] as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data_Guru_dan_Tendik_' . $gender . '_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function hapus(Request $request)
    {
        $decoded = \Hashids::decode($request->id);
        if (empty($decoded)) {
            return response()->json(['status' => 'error', 'message' => 'ID tidak valid.']);
        }
        Guru::where('id', $decoded[0])->update([
            'status_aktif' => '0'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data guru berhasil dihapus.']);
    }
}
