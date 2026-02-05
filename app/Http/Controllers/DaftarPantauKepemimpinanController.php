<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKepemimpinan;
use App\Models\DaftarPantauKepesertaan;
use App\Models\DaftarPantauPengajar;
use App\Models\DaftarPantauManajemen;
use Carbon\Carbon;

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

        $kepesertaan = DaftarPantauKepesertaan::where('kelas_kepemimpinan_id', $id)->get();

        $pengajar = DaftarPantauPengajar::where('kelas_kepemimpinan_id', $id)->get();

        $manajemen = DaftarPantauManajemen::where('kelas_kepemimpinan_id', $id)->get();

        return view(
            'daftar-pantau.kepemimpinan.show',
            compact('kelas', 'kepesertaan', 'pengajar', 'manajemen')
        );
    }


    
}
