<?php

namespace App\Http\Controllers;

use App\Models\KelasKepemimpinan;
use App\Models\Pelatihan;
use App\Models\Balai;
use Illuminate\Http\Request;

class KelasKepemimpinanController extends Controller
{
    /**
     * Tampilkan daftar kelas kepemimpinan
     */
    public function index()
    {
        $kelas = KelasKepemimpinan::with('pelatihan')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('kelas.kepemimpinan.index', compact('kelas'));
    }

    /**
     * Form tambah kelas (ADMIN)
     */
    public function create()
    {
        // Mengambil data pelatihan
        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();
        
        // Mengambil data balai (ditambahkan orderBy agar rapi di dropdown view)
        $balai = Balai::orderBy('nama_balai')->get(); 

        // Menggabungkan keduanya di dalam compact()
        return view('kelas.kepemimpinan.create', compact('pelatihan', 'balai'));
    }

    /**
     * Simpan data kelas (ADMIN)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'pelatihan_id'   => 'required|exists:tb_pelatihan,id',
            'angkatan'       => 'required|string|max:50', // <-- PENAMBAHAN VALIDASI ANGKATAN
            'balai_id'       => 'required|exists:tb_balai,id',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 1. Cari data Balai berdasarkan balai_id yang dipilih dari form
        $dataBalai = Balai::findOrFail($request->balai_id);

        // 2. Simpan data termasuk angkatan
        KelasKepemimpinan::create([
            'pelatihan_id'    => $request->pelatihan_id,
            'angkatan'        => $request->angkatan, // <-- PENAMBAHAN INPUT ANGKATAN
            'balai'           => $dataBalai->nama_balai, 
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()
            ->route('kelas.kepemimpinan.index')
            ->with('success', 'Kelas Kepemimpinan berhasil ditambahkan');
    }

    /**
     * Form edit kelas (ADMIN)
     */
    public function edit($id)
    {
        $this->authorizeAdmin();

        $kelas = KelasKepemimpinan::findOrFail($id);
        
        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();
        $balai = Balai::orderBy('nama_balai')->get();

        return view('kelas.kepemimpinan.edit', compact('kelas', 'pelatihan', 'balai'));
    }

    /**
     * Update data kelas (ADMIN)
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $kelas = KelasKepemimpinan::findOrFail($id);

        $request->validate([
            'pelatihan_id'   => 'required|exists:tb_pelatihan,id',
            'angkatan'       => 'required|string|max:50', // <-- PENAMBAHAN VALIDASI ANGKATAN
            'balai_id'       => 'required|exists:tb_balai,id',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 1. Cari data Balai yang baru dipilih
        $dataBalai = Balai::findOrFail($request->balai_id);

        // 2. Update data termasuk angkatan
        $kelas->update([
            'pelatihan_id'    => $request->pelatihan_id,
            'angkatan'        => $request->angkatan, // <-- PENAMBAHAN INPUT ANGKATAN
            'balai'           => $dataBalai->nama_balai, 
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('kelas.kepemimpinan.index')
            ->with('success', 'Kelas Kepemimpinan berhasil diperbarui');
    }

    /**
     * Hapus data kelas (ADMIN)
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        KelasKepemimpinan::findOrFail($id)->delete();

        return redirect()->route('kelas.kepemimpinan.index')
            ->with('success', 'Kelas Kepemimpinan berhasil dihapus');
    }

    /**
     * Proteksi admin
     */
    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}