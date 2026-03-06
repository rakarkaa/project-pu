<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPantau;
use Illuminate\Support\Facades\Auth;

class JenisPantauController extends Controller
{
    public function index()
    {
        $jenisPantau = JenisPantau::orderBy('nama_pantau', 'asc')->get();
        return view('jenis_pantau.index', compact('jenisPantau'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('jenis_pantau.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_pantau' => 'required|string|max:255',
        ]);

        JenisPantau::create($request->all());

        return redirect()->route('jenis-pantau.index')
            ->with('success', 'Data Jenis Pantau berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $jenisPantau = JenisPantau::findOrFail($id);
        return view('jenis_pantau.edit', compact('jenisPantau'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $jenisPantau = JenisPantau::findOrFail($id);

        $request->validate([
            'nama_pantau' => 'required|string|max:255',
        ]);

        $jenisPantau->update($request->all());

        return redirect()->route('jenis-pantau.index')
            ->with('success', 'Data Jenis Pantau berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        JenisPantau::findOrFail($id)->delete();

        return redirect()->route('jenis-pantau.index')
            ->with('success', 'Data Jenis Pantau berhasil dihapus');
    }

    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }
}