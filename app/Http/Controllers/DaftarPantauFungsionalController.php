<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasFungsional;
use App\Models\DaftarPantauKepesertaanFung;
use App\Models\DaftarPantauPengajarFung;
use App\Models\DaftarPantauManajemenFung;
use Carbon\Carbon;

class DaftarPantauFungsionalController extends Controller
{
        public function index()
    {
        $kelas = KelasFungsional::with('pelatihan')->get();

        return view('daftar-pantau.fungsional.index', compact('kelas'));
    }

    public function show($id)
    {
        $kelas = KelasFungsional::with('pelatihan')->findOrFail($id);

        $kepesertaan = DaftarPantauKepesertaanFung::where('kelas_fungsional_id', $id)->get();

        $pengajar = DaftarPantauPengajarFung::where('kelas_fungsional_id', $id)->get();

        $manajemen = DaftarPantauManajemenFung::where('kelas_fungsional_id', $id)->get();

        return view(
            'daftar-pantau.fungsional.show',
            compact('kelas', 'kepesertaan', 'pengajar', 'manajemen')
        );
    }
}
