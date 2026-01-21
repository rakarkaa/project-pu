<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihan = Pelatihan::orderBy('tahun', 'desc')->get();
        return view('pelatihan.index', compact('pelatihan'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('pelatihan.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $request->validate([
            'nama_pelatihan' => 'required',
            'jenis_pelatihan' => 'required',
            'keterangan' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        Pelatihan::create($request->all());

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $pelatihan = Pelatihan::findOrFail($id);
        return view('pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $pelatihan = Pelatihan::findOrFail($id);

        $request->validate([
            'nama_pelatihan' => 'required',
            'jenis_pelatihan' => 'required',
            'keterangan' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        $pelatihan->update($request->all());

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        Pelatihan::findOrFail($id)->delete();

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil dihapus');
    }
}
