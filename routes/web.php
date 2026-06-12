<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Jurusancontroller;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\Periodecontroller;
use App\Http\Controllers\Siswacontroller;
use Illuminate\Support\Facades\Route;

Route::get('/login', [Logincontroller::class, 'index'])->name('login');
Route::post('/loginUser', [Logincontroller::class, 'loginuser'])->middleware('throttle:5,1')->name('loginUser');
Route::get('/logout', [Logincontroller::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});
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
    Route::get('admin/siswa_edit/step1/{id}/{st}', [Siswacontroller::class, 'editstep1'])->name('siswa.edit.step1');
    Route::put('update/step1/{id}', [Siswacontroller::class, 'updateStep1'])->name('siswa.update.step1');
    Route::get('admin/siswa_edit/step2/{id}/{st}', [Siswacontroller::class, 'editstep2'])->name('siswa.edit.step2');
    Route::put('update/step2/{id}', [Siswacontroller::class, 'updateStep2'])->name('siswa.update.step2');
    Route::get('admin/siswa_edit/step3/{id}/{st}', [Siswacontroller::class, 'editstep3'])->name('siswa.edit.step3');
    Route::put('update/step3/{id}', [Siswacontroller::class, 'updateStep3'])->name('siswa.update.step3');
    Route::get('admin/siswa_edit/step4/{id}/{st}', [Siswacontroller::class, 'editstep4'])->name('siswa.edit.step4');
    Route::put('update/step4/{id}', [Siswacontroller::class, 'updateStep4'])->name('siswa.update.step4');
    Route::get('/get-kota/{provinsi_id}', [Siswacontroller::class, 'get_kabupaten']);
    Route::get('/get-kecamatan/{kabupaten_id}', [Siswacontroller::class, 'get_kecamatan']);
    Route::get('/get-desa/{kecamatan_id}', [Siswacontroller::class, 'get_desa']);
    Route::post('/batal', [Siswacontroller::class, 'batal'])->name('siswa.batal');
    Route::get('admin/siswa_show/{id}', [Siswacontroller::class, 'show'])->name('siswa.show');
    Route::get('admin/siswa_upload/{id}', [Siswacontroller::class, 'upload'])->name('siswa.upload');
    Route::put('update/upload/{id}', [Siswacontroller::class, 'updateUpload'])->name('siswa.update.upload');
    Route::post('/hapus', [Siswacontroller::class, 'hapus'])->name('siswa.hapus');
});
