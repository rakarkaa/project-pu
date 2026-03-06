<?php

namespace App\Http\Controllers;

use App\Models\KelasFungsional;
use App\Models\Pelatihan;
use App\Models\Balai;
use Illuminate\Http\Request;

class KelasFungsionalController extends Controller
{
    /**
     * Tampilkan daftar kelas fungsional
     * (ADMIN & USER)
     */
    public function index()
    {
        $kelas = KelasFungsional::with('pelatihan')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('kelas.fungsional.index', compact('kelas'));
    }

    /**
     * Form tambah kelas fungsional
     * (ADMIN ONLY)
     */
    public function create()
    {
        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();
        $balai = Balai::orderBy('nama_balai')->get(); 

        return view('kelas.fungsional.create', compact('pelatihan', 'balai'));
    }

    /**
     * Simpan data kelas fungsional
     * (ADMIN ONLY)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin(); // Jangan lupa panggil proteksi ini

        $request->validate([
            'pelatihan_id'   => 'required|exists:tb_pelatihan,id',
            'balai_id'       => 'required|exists:tb_balai,id', // PERBAIKAN: Ubah jadi balai_id
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 1. Cari data Balai berdasarkan balai_id yang dipilih dari form dropdown
        $dataBalai = Balai::findOrFail($request->balai_id); // PERBAIKAN: Gunakan balai_id

        // 2. Simpan 'nama_balai' ke dalam kolom 'balai'
        KelasFungsional::create([
            'pelatihan_id'    => $request->pelatihan_id,
            'balai'           => $dataBalai->nama_balai, // PERBAIKAN: Ambil properti nama_balai
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()
            ->route('kelas.fungsional.index')
            ->with('success', 'Kelas fungsional berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $kelas = KelasFungsional::findOrFail($id);
        
        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();
        $balai = Balai::orderBy('nama_balai')->get();

        return view('kelas.fungsional.edit', compact('kelas', 'pelatihan', 'balai'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $kelas = KelasFungsional::findOrFail($id);

        $request->validate([
            'pelatihan_id'   => 'required|exists:tb_pelatihan,id',
            'balai_id'       => 'required|exists:tb_balai,id',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 1. Cari data Balai yang baru dipilih di dropdown edit
        $dataBalai = Balai::findOrFail($request->balai_id);

        // 2. Update dengan nama balai
        $kelas->update([
            'pelatihan_id'    => $request->pelatihan_id,
            'balai'           => $dataBalai->nama_balai, 
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('kelas.fungsional.index')
            ->with('success', 'Kelas Fungsional berhasil diperbarui');
    }

    /**
     * Hapus data kelas (ADMIN)
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        KelasFungsional::findOrFail($id)->delete();

        return redirect()->route('kelas.fungsional.index')
            ->with('success', 'Kelas Fungsional berhasil dihapus');
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