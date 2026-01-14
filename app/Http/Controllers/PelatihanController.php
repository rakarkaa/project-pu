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
        return view('pelatihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelatihan' => 'required',
            'jenis_pelatihan' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        Pelatihan::create($request->all());

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        return view('pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $request->validate([
            'nama_pelatihan' => 'required',
            'jenis_pelatihan' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        $pelatihan->update($request->all());

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Pelatihan::findOrFail($id)->delete();

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil dihapus');
    }
}
