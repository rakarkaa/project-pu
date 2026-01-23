<?php

namespace App\Http\Controllers;

use App\Models\KelasKepemimpinan;
use App\Models\Pelatihan;
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
        $this->authorizeAdmin();

        $pelatihan = Pelatihan::orderBy('nama_pelatihan')->get();

        return view('kelas.kepemimpinan.create', compact('pelatihan'));
    }

    /**
     * Simpan data kelas (ADMIN)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'pelatihan_id'   => 'required|exists:tb_pelatihan,id',
            'balai'          => 'required|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        KelasKepemimpinan::create($request->all());

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

        return view('kelas.kepemimpinan.edit', compact('kelas', 'pelatihan'));
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
            'balai'          => 'required|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $kelas->update($request->all());

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
