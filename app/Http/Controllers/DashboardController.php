<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKepemimpinan;
use App\Models\KelasFungsional;
use App\Models\DaftarPantauKepesertaan;
use App\Models\DaftarPantauKepesertaanFung;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung Total Kelas Aktif
        $totalKepemimpinan = KelasKepemimpinan::count();
        $totalFungsional = KelasFungsional::count();

        // 2. Menghitung Total Dokumen Pending (Proses Penyusunan & Proses TTD)
        $pendingKepemimpinan = DaftarPantauKepesertaan::whereIn('keterangan', ['Proses Penyusunan', 'Proses TTD'])->count();
        $pendingFungsional = DaftarPantauKepesertaanFung::whereIn('keterangan', ['Proses Penyusunan', 'Proses TTD'])->count();
        $totalPending = $pendingKepemimpinan + $pendingFungsional;

        // 3. Menghitung Total Dokumen Selesai (Terkonfirmasi)
        $selesaiKepemimpinan = DaftarPantauKepesertaan::where('keterangan', 'Terkonfirmasi')->count();
        $selesaiFungsional = DaftarPantauKepesertaanFung::where('keterangan', 'Terkonfirmasi')->count();
        $totalSelesai = $selesaiKepemimpinan + $selesaiFungsional;

        // 4. Kirim semua variabel angka tersebut ke view 'dashboard'
        return view('dashboard', compact(
            'totalKepemimpinan', 
            'totalFungsional', 
            'totalPending', 
            'totalSelesai'
        ));
    }
}