<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan view ini ada
    }

    // Anda juga perlu metode untuk menangani login
    public function login(Request $request)
    {
        // Logika untuk menangani login
    }
}

