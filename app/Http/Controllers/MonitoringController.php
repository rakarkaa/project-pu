<?php

namespace App\Http\Controllers;

use App\Models\KelasKepemimpinan;
use App\Models\KelasFungsional;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        // Siapkan "keranjang" kosong untuk menampung semua baris pemantauan
        $semuaPemantauan = collect();

        // ==========================================
        // 1. BONGKAR DATA KEPEMIMPINAN
        // ==========================================
        $kepemimpinan = KelasKepemimpinan::with(['pelatihan', 'daftarPantauKepesertaan'])->get();
        
        foreach ($kepemimpinan as $kelas) {
            foreach ($kelas->daftarPantauKepesertaan as $pantau) {
                // Masukkan data spesifik per-dokumen ke keranjang
                $semuaPemantauan->push((object)[
                    'nama_pelatihan'  => $kelas->pelatihan->nama_pelatihan ?? '-',
                    'tanggal_mulai'   => $kelas->tanggal_mulai,
                    'tanggal_selesai' => $kelas->tanggal_selesai,
                    'jenis_kelas'     => 'Kepemimpinan',
                    'jenis_pantau'    => $pantau->jenis_pantau,
                    'tujuan'          => $pantau->tujuan,
                    'pic'             => $pantau->pic,
                    
                    // Field di bawah ini wajib dikirim agar Smart Detector di Blade tidak error
                    'keterangan'      => $pantau->keterangan,
                    'keterangan_dua'  => $pantau->keterangan_dua,
                    'status_pantau'   => $pantau->status_pantau,
                ]);
            }
        }

        // ==========================================
        // 2. BONGKAR DATA FUNGSIONAL
        // ==========================================
        $fungsional = KelasFungsional::with(['pelatihan', 'daftarPantauKepesertaanFung'])->get();
        
        foreach ($fungsional as $kelas) {
            foreach ($kelas->daftarPantauKepesertaanFung as $pantau) {
                // Masukkan data spesifik per-dokumen ke keranjang
                $semuaPemantauan->push((object)[
                    'nama_pelatihan'  => $kelas->pelatihan->nama_pelatihan ?? '-',
                    'tanggal_mulai'   => $kelas->tanggal_mulai,
                    'tanggal_selesai' => $kelas->tanggal_selesai,
                    'jenis_kelas'     => 'Fungsional',
                    'jenis_pantau'    => $pantau->jenis_pantau,
                    'tujuan'          => $pantau->tujuan,
                    'pic'             => $pantau->pic,
                    
                    // Field di bawah ini wajib dikirim agar Smart Detector di Blade tidak error
                    'keterangan'      => $pantau->keterangan,
                    'keterangan_dua'  => $pantau->keterangan_dua,
                    'status_pantau'   => $pantau->status_pantau,
                ]);
            }
        }

        // ==========================================
        // 3. URUTKAN DATA
        // ==========================================
        // Urutkan semua data dari kelas yang paling baru
        $semuaPemantauan = $semuaPemantauan->sortByDesc('tanggal_mulai')->values();

        return view('monitoring.index', compact('semuaPemantauan'));
    }
}