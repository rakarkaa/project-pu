<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarPantauController extends Controller
{
    public function kepemimpinan()
    {
        return view('daftar-pantau.kepemimpinan.index');
    }

    public function fungsional()
    {
        return view('daftar-pantau.fungsional.index');
    }
}
