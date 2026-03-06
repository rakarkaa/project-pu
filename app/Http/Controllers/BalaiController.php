<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balai;
use Illuminate\Support\Facades\Auth;

class BalaiController extends Controller
{
    public function index()
    {
        $balai = Balai::orderBy('nama_balai', 'asc')->get();
        return view('balai.index', compact('balai'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('balai.create');
    }


    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_balai' => 'required',
            'keterangan' => 'required',
        ]);

        Balai::create($request->all());

        return redirect()->route('balai.index')
            ->with('success', 'Data balai berhasil ditambahkan');
    }


    public function edit($id)
    {
        $this->authorizeAdmin();

        $balai = Balai::findOrFail($id);
        return view('balai.edit', compact('balai'));
    }


    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $balai = Balai::findOrFail($id);

        $request->validate([
            'nama_balai' => 'required',
            'keterangan' => 'required',
        ]);

        $balai->update($request->all());

        return redirect()->route('balai.index')
            ->with('success', 'Data balai berhasil diperbarui');
    }


    public function destroy($id)
    {
        $this->authorizeAdmin();

        Balai::findOrFail($id)->delete();

        return redirect()->route('balai.index')
            ->with('success', 'Data balai berhasil dihapus');
    }


    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }

}
