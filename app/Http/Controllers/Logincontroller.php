<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Gurukeluarga;

class Logincontroller extends Controller
{
    public function index()
    {
        $title = 'Login | SIANTA';
        $tahunAjaran = \App\Models\Periode::where('status', 1)->first();
        return view('auth.login', compact('title', 'tahunAjaran'));
    }

    public function loginuser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'), true)) { // Secara default mengaktifkan remember me untuk keandalan sesi lokal
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') {
                $rute = route('dashboard');
            } elseif ($user->role === 'guru') {
                $rute = route('guru.dashboard');
            } else {
                $rute = '/';
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'url' => $rute
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email atau password salah.'
        ], 401);
    }

    public function registeruser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email|unique:guru,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create User
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]);

            // 2. Create Guru
            $guru = Guru::create([
                'nama' => $request->name,
                'email' => $request->email,
                'status_aktif' => 1,
            ]);

            // 3. Create Guru Keluarga
            Gurukeluarga::create([
                'guru_id' => $guru->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Registrasi berhasil! Silakan masuk.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
