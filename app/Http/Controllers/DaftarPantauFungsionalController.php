<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasFungsional;
use App\Models\DaftarPantauKepesertaanFung;
use App\Models\JenisPantau;
use App\Models\Pic;
use Illuminate\Support\Facades\Storage;

class DaftarPantauFungsionalController extends Controller
{
    // FUNGSI INDEX (Mencegah Error Route)
    public function index()
    {
        $kelas = KelasFungsional::with('pelatihan')->orderBy('tanggal_mulai', 'desc')->get();
        return view('daftar-pantau.fungsional.index', compact('kelas'));
    }

    public function show($id)
    {
        $kelas = KelasFungsional::with('pelatihan')->findOrFail($id);
        $kepesertaan = DaftarPantauKepesertaanFung::where('kelas_fungsional_id', $id)->get();
        $jenisPantau = JenisPantau::all();
        $pics = Pic::orderBy('nama', 'asc')->get();

        return view('daftar-pantau.fungsional.show', compact('kelas', 'kepesertaan', 'jenisPantau', 'pics'));
    }

    public function store(Request $request, $kelasId)
    {
        $this->authorizeAdmin();

        $request->validate([
            'jenis_pantau'   => 'required|string',
            'keterangan'     => 'required|string',
            'pejabat_ttd'    => 'required|string',
            'pic'            => 'required|string',
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran/kepesertaan_fung', 'public');
        }

        DaftarPantauKepesertaanFung::create([
            'kelas_fungsional_id' => $kelasId,
            'jenis_pantau'        => $request->jenis_pantau,
            'keterangan'          => $request->keterangan,
            'keterangan_dua'      => $request->keterangan_dua,
            'pejabat_ttd'         => $request->pejabat_ttd,
            'pic'                 => $request->pic,
            'batas_waktu'         => $request->batas_waktu,
            'deadline_hari'       => $request->deadline_hari,
            'tujuan'              => $request->tujuan,
            'lampiran'            => $lampiranPath,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $item = DaftarPantauKepesertaanFung::findOrFail($id);
        $jenisPantau = JenisPantau::all();
        $pics = Pic::orderBy('nama', 'asc')->get();

        return view('daftar-pantau.fungsional.edit_kepesertaan', compact('item', 'jenisPantau', 'pics'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $item = DaftarPantauKepesertaanFung::findOrFail($id);

        $request->validate([
            'jenis_pantau'   => 'required|string',
            'keterangan'     => 'required|string',
            'pejabat_ttd'    => 'required|string',
            'pic'            => 'required|string',
            'tujuan'         => 'required|string',
        ]);

        $data = $request->only([
            'jenis_pantau', 'keterangan', 'keterangan_dua', 
            'pejabat_ttd', 'pic', 'batas_waktu', 'deadline_hari', 'tujuan'
        ]);

        if ($request->hasFile('lampiran')) {
            if ($item->lampiran) Storage::disk('public')->delete($item->lampiran);
            $data['lampiran'] = $request->file('lampiran')->store('lampiran/kepesertaan_fung', 'public');
        }

        $item->update($data);

        return redirect()->route('daftar-pantau.fungsional.show', $item->kelas_fungsional_id)
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        $item = DaftarPantauKepesertaanFung::findOrFail($id);
        if ($item->lampiran) Storage::disk('public')->delete($item->lampiran);
        $item->delete();
        
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak');
        }
    }
}