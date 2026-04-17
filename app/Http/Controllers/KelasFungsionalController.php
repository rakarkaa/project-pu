<?php

namespace App\Http\Controllers;

use App\Models\KelasFungsional;
use App\Models\Pelatihan;
use App\Models\Balai;
use App\Models\PolaPenyelenggaraan; // TAMBAHAN BARU
use Illuminate\Http\Request;

class KelasFungsionalController extends Controller
{
    public function index()
    {
        $kelas = KelasFungsional::with('pelatihan')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('kelas.fungsional.index', compact('kelas'));
    }

    public function create()
    {
        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();
        $balai = Balai::orderBy('nama_balai')->get(); 
        $pola = PolaPenyelenggaraan::orderBy('penyelenggara')->get(); // TAMBAHAN BARU

        return view('kelas.fungsional.create', compact('pelatihan', 'balai', 'pola'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'pelatihan_id'         => 'required|exists:tb_pelatihan,id',
            'angkatan'             => 'required|string|max:50',
            'balai_id'             => 'required|exists:tb_balai,id',
            'pola_penyelenggaraan' => 'required|string', // TAMBAHAN BARU
            'total_peserta'        => 'required|integer|min:1',
            'tanggal_mulai'        => 'required|date',
            'tanggal_selesai'      => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $dataBalai = Balai::findOrFail($request->balai_id);

        KelasFungsional::create([
            'pelatihan_id'         => $request->pelatihan_id,
            'angkatan'             => $request->angkatan,
            'balai'                => $dataBalai->nama_balai,
            'pola_penyelenggaraan' => $request->pola_penyelenggaraan, // SIMPAN KE DB
            'total_peserta'        => $request->total_peserta,
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $request->tanggal_selesai,
        ]);

        return redirect()->route('kelas.fungsional.index')
            ->with('success', 'Kelas Fungsional berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kelas = KelasFungsional::findOrFail($id);
        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();
        $balai = Balai::orderBy('nama_balai')->get();
        $pola = PolaPenyelenggaraan::orderBy('penyelenggara')->get(); // TAMBAHAN BARU

        return view('kelas.fungsional.edit', compact('kelas', 'pelatihan', 'balai', 'pola'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $kelas = KelasFungsional::findOrFail($id);

        $request->validate([
            'pelatihan_id'         => 'required|exists:tb_pelatihan,id',
            'angkatan'             => 'required|string|max:50',
            'balai_id'             => 'required|exists:tb_balai,id',
            'pola_penyelenggaraan' => 'required|string', // TAMBAHAN BARU
            'total_peserta'        => 'required|integer|min:1',
            'tanggal_mulai'        => 'required|date',
            'tanggal_selesai'      => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $dataBalai = Balai::findOrFail($request->balai_id);

        $kelas->update([
            'pelatihan_id'         => $request->pelatihan_id,
            'angkatan'             => $request->angkatan,
            'balai'                => $dataBalai->nama_balai,
            'pola_penyelenggaraan' => $request->pola_penyelenggaraan, // UPDATE KE DB
            'total_peserta'        => $request->total_peserta,
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $request->tanggal_selesai,
        ]);

        return redirect()->route('kelas.fungsional.index')
            ->with('success', 'Kelas Fungsional berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        KelasFungsional::findOrFail($id)->delete();
        return redirect()->route('kelas.fungsional.index')->with('success', 'Kelas Fungsional dihapus');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }
}