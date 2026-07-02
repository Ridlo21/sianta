<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpmbSyncController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Sinkronisasi SPMB';

        try {
            // Test the SPMB connection first
            DB::connection('spmb')->getPdo();
            $connectionError = null;
        } catch (\Exception $e) {
            $connectionError = 'Gagal terhubung ke database SPMB: ' . $e->getMessage();
        }

        $spmbStudents = [];
        $stats = [
            'total' => 0,
            'synced' => 0,
            'pending' => 0,
        ];

        if (!$connectionError) {
            try {
                // Fetch all valid SPMB candidates
                $spmbStudentsRaw = DB::connection('spmb')->table('siswa')
                    ->where('status', '1')
                    ->orderBy('id_person', 'desc')
                    ->get();

                $existingNiks = Siswa::pluck('nik')->toArray();

                foreach ($spmbStudentsRaw as $student) {
                    $isSynced = in_array($student->nik, $existingNiks);
                    
                    // Resolve major name
                    $spmbJurusan = DB::connection('spmb')->table('jurusan')
                        ->where('id', $student->jurusan_id)
                        ->first();
                    $jurusanName = $spmbJurusan ? $spmbJurusan->program_keahlian . ' (' . $spmbJurusan->kons_keahlian . ')' : 'Tidak Diketahui';

                    $spmbStudents[] = (object)[
                        'id_person' => $student->id_person,
                        'nama' => $student->nama,
                        'nik' => $student->nik,
                        'nisn' => $student->nisn,
                        'jurusan_name' => $jurusanName,
                        'status_step' => $student->status_step ?? 'N/A',
                        'is_synced' => $isSynced
                    ];

                    $stats['total']++;
                    if ($isSynced) {
                        $stats['synced']++;
                    } else {
                        $stats['pending']++;
                    }
                }
            } catch (\Exception $e) {
                $connectionError = 'Terjadi kesalahan saat mengambil data dari SPMB: ' . $e->getMessage();
            }
        }

        return view('admin.siswa.spmb_sync', compact('title', 'user', 'spmbStudents', 'stats', 'connectionError'));
    }

    public function syncBatch()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            DB::connection('spmb')->getPdo();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal terhubung ke database SPMB: ' . $e->getMessage()
            ]);
        }

        // Get existing NIKs in Sianta to prevent duplicates
        $existingNiks = Siswa::pluck('nik')->toArray();

        // Get candidates to sync: status = '1' and nik not in existing NIKs
        $candidates = DB::connection('spmb')->table('siswa')
            ->where('status', '1')
            ->orderBy('id_person', 'asc') // Sync oldest first
            ->get();

        $candidatesToSync = [];
        foreach ($candidates as $cand) {
            if (!in_array($cand->nik, $existingNiks)) {
                $candidatesToSync[] = $cand;
                if (count($candidatesToSync) >= 10) {
                    break;
                }
            }
        }

        if (empty($candidatesToSync)) {
            return response()->json([
                'status' => 'info',
                'message' => 'Semua data siswa dari SPMB sudah tersinkronisasi.'
            ]);
        }

        $successCount = 0;
        $syncedNames = [];
        $errors = [];

        $spmbPublicPath = 'c:/xampp/htdocs/spmb/public/';
        $spmbStoragePath = 'c:/xampp/htdocs/spmb/storage/app/public/';
        $siantaPublicPath = public_path('gambar_berkas/berkas_siswa/');

        if (!file_exists($siantaPublicPath)) {
            mkdir($siantaPublicPath, 0755, true);
        }

        $columns = Schema::getColumnListing('siswa');
        $fileFields = [
            'foto_warna_santri',
            'foto_wali_santri_warna',
            'foto_scan_kk',
            'foto_scan_akta',
            'foto_scan_skck',
            'foto_scan_ket_sehat',
            'foto_ijazah',
            'foto_skl',
            'file_kip'
        ];

        foreach ($candidatesToSync as $candidate) {
            DB::beginTransaction();
            try {
                // 1. Resolve jurusan_id
                $spmbJurusan = DB::connection('spmb')->table('jurusan')
                    ->where('id', $candidate->jurusan_id)
                    ->first();

                $targetJurusanId = null;
                if ($spmbJurusan) {
                    $match = Jurusan::where('program_keahlian', $spmbJurusan->program_keahlian)
                        ->orWhere('kons_keahlian', $spmbJurusan->kons_keahlian)
                        ->first();
                    if ($match) {
                        $targetJurusanId = $match->id;
                    } else {
                        // Fallback matching
                        if ($candidate->jurusan_id == 10) {
                            $targetJurusanId = 1; // RPL
                        } elseif ($candidate->jurusan_id == 11) {
                            $targetJurusanId = 2; // Akuntansi
                        }
                    }
                }

                if (!$targetJurusanId) {
                    throw new \Exception("Jurusan tidak ditemukan di SIANTA untuk siswa: {$candidate->nama}");
                }

                // 2. Prepare data for insert
                $insertData = [];
                foreach ($columns as $column) {
                    if (in_array($column, ['id_person', 'nis', 'status', 'user_id', 'created_at', 'updated_at'])) {
                        continue;
                    }

                    if (property_exists($candidate, $column)) {
                        $insertData[$column] = $candidate->$column;
                    }
                }

                $insertData['jurusan_id'] = $targetJurusanId;
                $insertData['status'] = 'Aktif';
                $insertData['user_id'] = Auth::id();
                $insertData['created_at'] = now();
                $insertData['updated_at'] = now();

                // Clear out file fields initially so they don't point to non-existent filenames
                foreach ($fileFields as $field) {
                    $insertData[$field] = null;
                }

                // 3. Create Siswa
                $newSiswa = Siswa::create($insertData);

                // 4. Generate NIS according to updateStep4 in Siswacontroller
                $jurusan = Jurusan::findOrFail($targetJurusanId);
                $nomorUmum = Siswa::whereNotNull('nis')->count() + 1;
                $nomorJurusan = Siswa::where('jurusan_id', $jurusan->id)
                    ->where('id_person', '!=', $newSiswa->id_person)
                    ->count() + 1;

                $A = str_pad($nomorUmum, 4, '0', STR_PAD_LEFT);
                $B = str_pad($nomorJurusan, 3, '0', STR_PAD_LEFT);
                $C = $jurusan->kode_nomenklatur;
                $nis = "{$A}/{$B}.{$C}";

                $newSiswa->nis = $nis;
                $newSiswa->save();

                // 5. Copy files
                $updatedFiles = [];
                foreach ($fileFields as $field) {
                    if (isset($candidate->$field) && $candidate->$field) {
                        $spmbFileRelPath = str_replace('\\', '/', $candidate->$field);
                        
                        $sourceFilePath = null;
                        if (file_exists($spmbStoragePath . $spmbFileRelPath)) {
                            $sourceFilePath = $spmbStoragePath . $spmbFileRelPath;
                        } elseif (file_exists($spmbPublicPath . $spmbFileRelPath)) {
                            $sourceFilePath = $spmbPublicPath . $spmbFileRelPath;
                        }

                        if ($sourceFilePath) {
                            $extension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);
                            $newFilename = $field . '_' . $newSiswa->id_person . '_' . time() . '.' . $extension;
                            $destFilePath = $siantaPublicPath . $newFilename;

                            if (copy($sourceFilePath, $destFilePath)) {
                                $updatedFiles[$field] = $newFilename;
                            }
                        }
                    }
                }

                if (!empty($updatedFiles)) {
                    $newSiswa->update($updatedFiles);
                }

                DB::commit();
                $successCount++;
                $syncedNames[] = $candidate->nama;
            } catch (\Exception $e) {
                DB::rollBack();
                $errors[] = $e->getMessage();
            }
        }

        if ($successCount > 0) {
            $msg = $successCount . ' data siswa berhasil disinkronkan: ' . implode(', ', $syncedNames);
            if (!empty($errors)) {
                $msg .= '. Namun ada beberapa error: ' . implode('; ', $errors);
            }
            return response()->json([
                'status' => 'success',
                'message' => $msg
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyinkronkan data siswa: ' . implode('; ', $errors)
            ]);
        }
    }
}
