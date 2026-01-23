<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihan = Pelatihan::orderBy('tahun', 'desc')->get();
        return view('pelatihan.index', compact('pelatihan'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('pelatihan.create');
    }


    public function store(Request $request)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

        $pelatihan = Pelatihan::findOrFail($id);
        return view('pelatihan.edit', compact('pelatihan'));
    }


    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

        Pelatihan::findOrFail($id)->delete();

        return redirect()->route('pelatihan.index')
            ->with('success', 'Data pelatihan berhasil dihapus');
    }


    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }

}
