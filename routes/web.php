<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Logincontroller;
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

    // SISWA
    Route::get('/admin/siswa', [Siswacontroller::class, 'index'])->name('siswa');
});
