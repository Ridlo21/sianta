<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Gurucontroller;
use App\Http\Controllers\Jurusancontroller;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\Periodecontroller;
use App\Http\Controllers\Siswacontroller;
use App\Http\Controllers\Profilecontroller;
use App\Http\Controllers\Rombelcontroller;
use App\Http\Controllers\MataPelajarancontroller;
use App\Http\Controllers\PembelajaranController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [Logincontroller::class, 'index'])->name('login');
Route::post('/loginUser', [Logincontroller::class, 'loginuser'])->middleware('throttle:5,1')->name('loginUser');
Route::get('/logout', [Logincontroller::class, 'logout'])->name('logout');

Route::get('/', function () {
    $siswaAktifCount = \App\Models\Siswa::where('status', 'Aktif')->count();
    $guruAktifCount = \App\Models\Guru::where('status_aktif', 1)->count();
    return view('welcome', compact('siswaAktifCount', 'guruAktifCount'));
});

Route::get('/guru/profile/{guru}', [Gurucontroller::class, 'publicProfile'])->name('guru.public-profile');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [Admincontroller::class, 'index'])->name('dashboard');

    // PERIODE AKADEMIK
    Route::get('/admin/periode', [Periodecontroller::class, 'index'])->name('periode');
    Route::get('/admin/periode_data', [Periodecontroller::class, 'periode_data'])->name('periode.data');
    Route::get('/admin/edit_periode/{id}', [Periodecontroller::class, 'edit'])->name('periode.edit');
    Route::post('/admin/periode_simpan', [Periodecontroller::class, 'store'])->name('periode.simpan');
    Route::post('/admin/periode_update', [Periodecontroller::class, 'update'])->name('periode.update');

    Route::get('/admin/jurusan', [Jurusancontroller::class, 'index'])->name('jurusan');
    Route::get('/admin/jurusan_data', [Jurusancontroller::class, 'jurusan_data'])->name('jurusan.data');
    Route::get('/admin/edit_jurusan/{id}', [Jurusancontroller::class, 'edit'])->name('jurusan.edit');
    Route::post('/admin/jurusan_simpan', [Jurusancontroller::class, 'store'])->name('jurusan.simpan');
    Route::post('/admin/jurusan_update', [Jurusancontroller::class, 'update'])->name('jurusan.update');

    // SISWA
    Route::get('/admin/siswa', [Siswacontroller::class, 'index'])->name('siswa');
    Route::get('/admin/siswa_data', [Siswacontroller::class, 'siswa_data'])->name('siswa.data');
    Route::post('admin/siswa_simpan', [Siswacontroller::class, 'store'])->name('siswa.store');
    Route::get('admin/siswa_edit/step1/{siswa}/{st}', [Siswacontroller::class, 'editstep1'])->name('siswa.edit.step1');
    Route::put('admin/siswa/update/step1/{siswa}', [Siswacontroller::class, 'updateStep1'])->name('siswa.update.step1');
    Route::get('admin/siswa_edit/step2/{siswa}/{st}', [Siswacontroller::class, 'editstep2'])->name('siswa.edit.step2');
    Route::put('admin/siswa/update/step2/{siswa}', [Siswacontroller::class, 'updateStep2'])->name('siswa.update.step2');
    Route::get('admin/siswa_edit/step3/{siswa}/{st}', [Siswacontroller::class, 'editstep3'])->name('siswa.edit.step3');
    Route::put('admin/siswa/update/step3/{siswa}', [Siswacontroller::class, 'updateStep3'])->name('siswa.update.step3');
    Route::get('admin/siswa_edit/step4/{siswa}/{st}', [Siswacontroller::class, 'editstep4'])->name('siswa.edit.step4');
    Route::put('admin/siswa/update/step4/{siswa}', [Siswacontroller::class, 'updateStep4'])->name('siswa.update.step4');
    Route::get('/get-kota/{provinsi_id}', [Siswacontroller::class, 'get_kabupaten']);
    Route::get('/get-kecamatan/{kabupaten_id}', [Siswacontroller::class, 'get_kecamatan']);
    Route::get('/get-desa/{kecamatan_id}', [Siswacontroller::class, 'get_desa']);
    Route::post('/admin/siswa/batal', [Siswacontroller::class, 'batal'])->name('siswa.batal');
    Route::get('admin/siswa_show/{siswa}', [Siswacontroller::class, 'show'])->name('siswa.show');
    Route::get('admin/siswa_print/{siswa}', [Siswacontroller::class, 'print'])->name('siswa.print');
    Route::get('admin/siswa_download/{siswa}/{field}', [Siswacontroller::class, 'downloadBerkas'])->name('siswa.download.berkas');
    Route::get('admin/siswa_upload/{siswa}', [Siswacontroller::class, 'upload'])->name('siswa.upload');
    Route::put('admin/siswa/update/upload/{siswa}', [Siswacontroller::class, 'updateUpload'])->name('siswa.update.upload');
    Route::post('/admin/siswa/hapus', [Siswacontroller::class, 'hapus'])->name('siswa.hapus');

    // GURU
    Route::get('/admin/guru', [Gurucontroller::class, 'index'])->name('guru');
    Route::get('/admin/guru_data', [Gurucontroller::class, 'guru_data'])->name('guru.data');
    Route::post('admin/guru_simpan', [Gurucontroller::class, 'store'])->name('guru.store');
    Route::get('admin/guru_edit/step1/{guru}/{st}', [Gurucontroller::class, 'editstep1'])->name('guru.edit.step1');
    Route::put('admin/guru/update/step1/{guru}', [Gurucontroller::class, 'updateStep1'])->name('guru.update.step1');
    Route::get('admin/guru_edit/step2/{guru}/{st}', [Gurucontroller::class, 'editstep2'])->name('guru.edit.step2');
    Route::put('admin/guru/update/step2/{guru}', [Gurucontroller::class, 'updateStep2'])->name('guru.update.step2');
    Route::post('/admin/guru/batal', [Gurucontroller::class, 'batal'])->name('guru.batal');
    Route::get('admin/guru_show/{guru}', [Gurucontroller::class, 'show'])->name('guru.show');
    Route::get('admin/guru_print/{guru}', [Gurucontroller::class, 'print'])->name('guru.print');
    Route::get('admin/guru_download/{guru}/{field}', [Gurucontroller::class, 'downloadBerkas'])->name('guru.download.berkas');
    Route::post('admin/guru/pendidikan', [Gurucontroller::class, 'storePendidikan'])->name('guru.pendidikan.store');
    Route::get('admin/guru_pendidikan_download/{id}', [Gurucontroller::class, 'downloadPendidikanBerkas'])->name('guru.pendidikan.download');
    Route::get('admin/guru_upload/{guru}', [Gurucontroller::class, 'upload'])->name('guru.upload');
    Route::put('admin/guru/update/upload/{guru}', [Gurucontroller::class, 'updateUpload'])->name('guru.update.upload');
    Route::post('/admin/guru/hapus', [Gurucontroller::class, 'hapus'])->name('guru.hapus');

    // ROMBEL
    Route::get('/admin/rombel', [Rombelcontroller::class, 'index'])->name('rombel');
    Route::get('/admin/rombel/{id}/students', [Rombelcontroller::class, 'getStudents'])->name('rombel.students');
    Route::post('/admin/rombel/simpan', [Rombelcontroller::class, 'store'])->name('rombel.simpan');
    Route::get('/admin/rombel/edit/{id}', [Rombelcontroller::class, 'edit'])->name('rombel.edit');
    Route::post('/admin/rombel/update', [Rombelcontroller::class, 'update'])->name('rombel.update');
    Route::post('/admin/rombel/hapus', [Rombelcontroller::class, 'hapus'])->name('rombel.hapus');
    Route::get('/admin/rombel/detail/{id}', [Rombelcontroller::class, 'show'])->name('rombel.show-detail');
    Route::get('/admin/rombel/print/{id}', [Rombelcontroller::class, 'print'])->name('rombel.print');
    Route::post('/admin/rombel/set-wali', [Rombelcontroller::class, 'setWali'])->name('rombel.set-wali');
    Route::post('/admin/rombel/pindah-siswa', [Rombelcontroller::class, 'pindahSiswa'])->name('rombel.pindah-siswa');
    Route::post('/admin/rombel/tambah-siswa', [Rombelcontroller::class, 'tambahSiswa'])->name('rombel.tambah-siswa');
    Route::get('/admin/rombel/pembagian-massal', [Rombelcontroller::class, 'pembagianMassal'])->name('rombel.pembagian-massal');
    Route::post('/admin/rombel/proses-pembagian-massal', [Rombelcontroller::class, 'prosesPembagianMassal'])->name('rombel.proses-pembagian-massal');

    // USER PROFILE
    Route::get('/admin/profile', [Profilecontroller::class, 'index'])->name('profile');
    Route::post('/admin/profile/update', [Profilecontroller::class, 'update'])->name('profile.update');
    Route::post('/admin/profile/password', [Profilecontroller::class, 'updatePassword'])->name('profile.password');

    // MATA PELAJARAN
    Route::get('/admin/mapel', [MataPelajarancontroller::class, 'index'])->name('mapel');
    Route::get('/admin/mapel_data', [MataPelajarancontroller::class, 'mapel_data'])->name('mapel.data');
    Route::post('/admin/mapel_simpan', [MataPelajarancontroller::class, 'store'])->name('mapel.simpan');
    Route::get('/admin/mapel_edit/{id}', [MataPelajarancontroller::class, 'edit'])->name('mapel.edit');
    Route::post('/admin/mapel_update', [MataPelajarancontroller::class, 'update'])->name('mapel.update');
    Route::post('/admin/mapel_hapus', [MataPelajarancontroller::class, 'hapus'])->name('mapel.hapus');

    // SEBARAN MAPEL (PEMBELAJARAN)
    Route::get('/admin/sebaran-mapel', [PembelajaranController::class, 'index'])->name('sebaran-mapel');
    Route::get('/admin/sebaran-mapel/rombel/{id}', [PembelajaranController::class, 'manage'])->name('sebaran-mapel.manage');
    Route::post('/admin/sebaran-mapel/simpan', [PembelajaranController::class, 'store'])->name('sebaran-mapel.simpan');
    Route::get('/admin/sebaran-mapel/edit/{id}', [PembelajaranController::class, 'edit'])->name('sebaran-mapel.edit');
    Route::post('/admin/sebaran-mapel/update', [PembelajaranController::class, 'update'])->name('sebaran-mapel.update');
    Route::post('/admin/sebaran-mapel/hapus', [PembelajaranController::class, 'hapus'])->name('sebaran-mapel.hapus');

    // JADWAL PEMBELAJARAN
    Route::get('/admin/jadwal', [App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal');
    Route::post('/admin/jadwal/version/create', [App\Http\Controllers\JadwalController::class, 'createVersion'])->name('jadwal.version.create');
    Route::post('/admin/jadwal/version/{id}/backup', [App\Http\Controllers\JadwalController::class, 'backupVersion'])->name('jadwal.version.backup');
    Route::get('/admin/jadwal/version/{id}/edit', [App\Http\Controllers\JadwalController::class, 'edit'])->name('jadwal.version.edit');
    Route::post('/admin/jadwal/save', [App\Http\Controllers\JadwalController::class, 'save'])->name('jadwal.save');
    Route::get('/admin/jadwal/version/{id}/print', [App\Http\Controllers\JadwalController::class, 'print'])->name('jadwal.print');
    Route::post('/admin/jadwal/version/{id}/delete', [App\Http\Controllers\JadwalController::class, 'deleteVersion'])->name('jadwal.version.delete');
    Route::post('/admin/jadwal/version/{id}/activate', [App\Http\Controllers\JadwalController::class, 'activateVersion'])->name('jadwal.version.activate');
});

