<?php

namespace App\Http\Controllers;

use App\Models\TujuanPenerimaSurat;
use Illuminate\Http\Request;

class TujuanPenerimaSuratController extends Controller
{
    public function index()
    {
        $data = TujuanPenerimaSurat::orderBy('nama_unitorganisasi', 'asc')->get();
        return view('tujuan.index', compact('data'));
    }

    public function create()
    {
        return view('tujuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unitorganisasi' => 'required|string|max:255',
            'nama_unitkerja'      => 'required|string|max:255'
        ]);

        TujuanPenerimaSurat::create($request->all());

        return redirect()->route('tujuan-surat.index')
            ->with('success', 'Data tujuan penerima surat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = TujuanPenerimaSurat::findOrFail($id);
        return view('tujuan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unitorganisasi' => 'required|string|max:255',
            'nama_unitkerja'      => 'required|string|max:255'
        ]);

        $item = TujuanPenerimaSurat::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('tujuan-surat.index')
            ->with('success', 'Data tujuan penerima surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = TujuanPenerimaSurat::findOrFail($id);
        $item->delete();

        return redirect()->route('tujuan-surat.index')
            ->with('success', 'Data tujuan penerima surat berhasil dihapus.');
    }
}