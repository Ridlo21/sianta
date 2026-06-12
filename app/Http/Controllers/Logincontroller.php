<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logincontroller extends Controller
{
    public function index()
    {
        $title = 'Login | SIANTA';
        return view('auth.login', compact('title'));
    }

    public function loginuser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'), true)) { // Secara default mengaktifkan remember me untuk keandalan sesi lokal
            $request->session()->regenerate();
            
            $rute = route('dashboard');
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

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
