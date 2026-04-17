<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pic;
use Illuminate\Support\Facades\Auth;

class PicController extends Controller
{
    public function index()
    {
        $pic = Pic::orderBy('nama', 'asc')->get();
        return view('pic.index', compact('pic'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('pic.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama' => 'required|string|max:255',
            'bagian' => 'required|string|max:255',
        ]);

        Pic::create($request->all());

        return redirect()->route('pic.index')
            ->with('success', 'Data PIC berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $pic = Pic::findOrFail($id);
        return view('pic.edit', compact('pic'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $pic = Pic::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'bagian' => 'required|string|max:255',
        ]);

        $pic->update($request->all());

        return redirect()->route('pic.index')
            ->with('success', 'Data PIC berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        Pic::findOrFail($id)->delete();

        return redirect()->route('pic.index')
            ->with('success', 'Data PIC berhasil dihapus');
    }

    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }
}