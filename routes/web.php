<?php

use App\Http\Controllers\Admincontroller;
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
    // SISWA
    Route::get('/admin/siswa', [Siswacontroller::class, 'index'])->name('siswa');
});
