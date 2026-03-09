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
        // AMBIL DATA DARI DATABASE (Bagian ini yang tadi terhapus)
        $kepemimpinan = KelasKepemimpinan::with(['pelatihan', 'daftarPantauKepesertaan'])->get();
        
        foreach ($kepemimpinan as $kelas) {
            foreach ($kelas->daftarPantauKepesertaan as $pantau) {
                // Tentukan level progres
                $level = $this->hitungLevel($pantau->keterangan);

                // Masukkan data spesifik per-dokumen ke keranjang
                $semuaPemantauan->push((object)[
                    'nama_pelatihan'  => $kelas->pelatihan->nama_pelatihan ?? '-',
                    'tanggal_mulai'   => $kelas->tanggal_mulai,
                    'tanggal_selesai' => $kelas->tanggal_selesai, // Jadwal selesai ditambahkan
                    'jenis_kelas'     => 'Kepemimpinan',
                    'jenis_pantau'    => $pantau->jenis_pantau,
                    'tujuan'          => $pantau->tujuan,
                    'keterangan'      => $pantau->keterangan,
                    'progress_level'  => $level,
                ]);
            }
        }

        // ==========================================
        // 2. BONGKAR DATA FUNGSIONAL
        // ==========================================
        // AMBIL DATA DARI DATABASE (Bagian ini juga wajib ada)
        $fungsional = KelasFungsional::with(['pelatihan', 'daftarPantauKepesertaanFung'])->get();
        
        foreach ($fungsional as $kelas) {
            foreach ($kelas->daftarPantauKepesertaanFung as $pantau) {
                // Tentukan level progres
                $level = $this->hitungLevel($pantau->keterangan);

                // Masukkan data spesifik per-dokumen ke keranjang
                $semuaPemantauan->push((object)[
                    'nama_pelatihan'  => $kelas->pelatihan->nama_pelatihan ?? '-',
                    'tanggal_mulai'   => $kelas->tanggal_mulai,
                    'tanggal_selesai' => $kelas->tanggal_selesai, // Jadwal selesai ditambahkan
                    'jenis_kelas'     => 'Fungsional',
                    'jenis_pantau'    => $pantau->jenis_pantau,
                    'tujuan'          => $pantau->tujuan,
                    'keterangan'      => $pantau->keterangan,
                    'progress_level'  => $level,
                ]);
            }
        }

        // 3. Urutkan semua data dari kelas yang paling baru
        $semuaPemantauan = $semuaPemantauan->sortByDesc('tanggal_mulai')->values();

        return view('monitoring.index', compact('semuaPemantauan'));
    }

    /**
     * Fungsi bantuan (helper) agar kode lebih rapi
     */
    private function hitungLevel($keterangan)
    {
        $ket = strtolower(trim($keterangan));
        if (str_contains($ket, 'konfirmasi')) return 4;
        if (str_contains($ket, 'terkirim')) return 3;
        if (str_contains($ket, 'ttd')) return 2;
        if (str_contains($ket, 'penyusunan')) return 1;
        
        return 0;
    }
}