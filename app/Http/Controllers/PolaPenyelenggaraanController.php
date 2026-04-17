<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolaPenyelenggaraan;
use Illuminate\Support\Facades\Auth;

class PolaPenyelenggaraanController extends Controller
{
    public function index()
    {
        $pola = PolaPenyelenggaraan::orderBy('penyelenggara', 'asc')->get();
        return view('pola_penyelenggaraan.index', compact('pola'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('pola_penyelenggaraan.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'penyelenggara' => 'required|string|max:255',
        ]);

        PolaPenyelenggaraan::create($request->all());

        return redirect()->route('pola-penyelenggaraan.index')
            ->with('success', 'Data Pola Penyelenggaraan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $pola = PolaPenyelenggaraan::findOrFail($id);
        return view('pola_penyelenggaraan.edit', compact('pola'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $pola = PolaPenyelenggaraan::findOrFail($id);

        $request->validate([
            'penyelenggara' => 'required|string|max:255',
        ]);

        $pola->update($request->all());

        return redirect()->route('pola-penyelenggaraan.index')
            ->with('success', 'Data Pola Penyelenggaraan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        PolaPenyelenggaraan::findOrFail($id)->delete();

        return redirect()->route('pola-penyelenggaraan.index')
            ->with('success', 'Data Pola Penyelenggaraan berhasil dihapus');
    }

    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }
}