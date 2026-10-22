<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanSekolahController extends Controller
{
    public function index()
    {
        return view('pengaturan-sekolah.index');
    }
}