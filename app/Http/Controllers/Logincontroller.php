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

        if (Auth::attempt($request->only('email', 'password'))) {
            $rute = route('dashboard');
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'url' => $rute
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
