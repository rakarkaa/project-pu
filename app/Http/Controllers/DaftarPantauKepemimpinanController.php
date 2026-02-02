<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKepemimpinan;

class DaftarPantauKepemimpinanController extends Controller
{
    public function index()
    {
        $kelas = KelasKepemimpinan::with('pelatihan')->get();

        return view('daftar-pantau.kepemimpinan.index', compact('kelas'));
    }

    public function show($id)
    {
        $kelas = KelasKepemimpinan::with('pelatihan')->findOrFail($id);

        return view('daftar-pantau.kepemimpinan.show', compact('kelas'));
    }
}
