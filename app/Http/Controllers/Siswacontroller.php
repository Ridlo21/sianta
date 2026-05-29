<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Siswacontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Siswa';

        return view('admin.siswa.index', compact('title', 'user'));
    }
}
