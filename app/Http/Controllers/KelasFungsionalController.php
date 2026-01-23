<?php

namespace App\Http\Controllers;

use App\Models\KelasFungsional;
use App\Models\Pelatihan;
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

        return view('kelas.fungsional.create', compact('pelatihan'));
    }

    /**
     * Simpan data kelas fungsional
     * (ADMIN ONLY)
     */

    public function store(Request $request)
    {
        $request->validate([
            'pelatihan_id'   => 'required|exists:tb_pelatihan,id',
            'balai'          => 'required|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        KelasFungsional::create([
            'pelatihan_id'    => $request->pelatihan_id,
            'balai'           => $request->balai,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()
            ->route('kelas.fungsional.index')
            ->with('success', 'Kelas fungsional berhasil ditambahkan');
    }

    public function edit($id)
    {
        // hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $kelas = KelasFungsional::findOrFail($id);
        $pelatihan = Pelatihan::all();

        return view('kelas.fungsional.edit', compact('kelas', 'pelatihan'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'pelatihan_id' => 'required',
            'balai' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $kelas = KelasFungsional::findOrFail($id);
        $kelas->update($request->all());

        return redirect()
            ->route('kelas.fungsional.index')
            ->with('success', 'Data kelas fungsional berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $kelas = KelasFungsional::findOrFail($id);
        $kelas->delete();

        return redirect()
            ->route('kelas.fungsional.index')
            ->with('success', 'Data kelas fungsional berhasil dihapus');
    }



}
