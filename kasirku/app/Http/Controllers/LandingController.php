<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Iluminate\Http\Request;

class LandingController extends Controller
{
    //function yang pertama kali dibuka
    public function index()
    {
        return view('landing'); //menampilkan halaman home
    }
}