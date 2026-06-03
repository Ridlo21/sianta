<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Jurusancontroller;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\Periodecontroller;
use App\Http\Controllers\Siswacontroller;
use Illuminate\Support\Facades\Route;

Route::get('/login', [Logincontroller::class, 'index'])->name('login');
Route::post('/loginUser', [Logincontroller::class, 'loginuser'])->name('loginUser');
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
});
