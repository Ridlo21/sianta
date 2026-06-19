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
        $gurukeluarga = Gurukeluarga::where('guru_id', $id)->first();
        $pekerjaan = Pekerjaan::all();
        $title = 'Guru';
        return view('admin.guru.step1', compact('guru', 'pekerjaan', 'gurukeluarga', 'agama', 'jurusan', 'provinsi', 'st', 'user', 'title'));
    }

    public function updateStep1(Request $request, $id)
    {
        DB::beginTransaction();

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
                'id' => $id,
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

    public function batal(Request $request)
    {
        $id = $request->id;
        $guru = Guru::findOrFail($id);

        $guru->delete();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $guru = Guru::with(['keluarga', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'desaDetail', 'jurusan', 'agama'])->findOrFail($id);
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru';

        return view('admin.guru.show', compact('title', 'user', 'guru'));
    }

    public function downloadBerkas($id, $field)
    {
        $guru = Guru::findOrFail($id);
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

    public function upload($id)
    {
        $guru = Guru::findOrFail($id);
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Guru';

        return view('admin.guru.upload', compact('title', 'user', 'guru'));
    }

    public function updateUpload(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $rules = [
            'foto' => ($guru->foto ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'scan_kk' => ($guru->scan_kk ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'scan_akta' => ($guru->scan_akta ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'scan_ktp' => ($guru->scan_ktp ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'scan_sk' => ($guru->scan_sk ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'scan_transkrip_nilai' => ($guru->scan_transkrip_nilai ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [
            'required' => ':attribute wajib diunggah.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berformat JPG, JPEG, atau PNG.',
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
                    $filename = $field . '_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();

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

    public function hapus(Request $request)
    {
        Guru::where('id', $request->id)->update([
            'status_aktif' => '0'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data guru berhasil dihapus.']);
    }
}
