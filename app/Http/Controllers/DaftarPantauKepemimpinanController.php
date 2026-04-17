<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKepemimpinan;
use App\Models\DaftarPantauKepesertaan;
use App\Models\JenisPantau;
use App\Models\Pic;
use Illuminate\Support\Facades\Storage;

class DaftarPantauKepemimpinanController extends Controller
{
    // FUNGSI INDEX (Mencegah Error Route)
    public function index()
    {
        $kelas = KelasKepemimpinan::with('pelatihan')->orderBy('tanggal_mulai', 'desc')->get();
        return view('daftar-pantau.kepemimpinan.index', compact('kelas'));
    }

    public function show($id)
    {
        $kelas = KelasKepemimpinan::with('pelatihan')->findOrFail($id);
        $kepesertaan = DaftarPantauKepesertaan::where('kelas_kepemimpinan_id', $id)->get();
        $jenisPantau = JenisPantau::all();
        $pics = Pic::orderBy('nama', 'asc')->get();

        return view('daftar-pantau.kepemimpinan.show', compact('kelas', 'kepesertaan', 'jenisPantau', 'pics'));
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
            $lampiranPath = $request->file('lampiran')->store('lampiran/kepesertaan', 'public');
        }

        DaftarPantauKepesertaan::create([
            'kelas_kepemimpinan_id' => $kelasId,
            'jenis_pantau'          => $request->jenis_pantau,
            'keterangan'            => $request->keterangan,
            'keterangan_dua'        => $request->keterangan_dua,
            'pejabat_ttd'           => $request->pejabat_ttd,
            'pic'                   => $request->pic,
            'batas_waktu'           => $request->batas_waktu,
            'deadline_hari'         => $request->deadline_hari,
            'tujuan'                => $request->tujuan,
            'lampiran'              => $lampiranPath,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $item = DaftarPantauKepesertaan::findOrFail($id);
        $jenisPantau = JenisPantau::all();
        $pics = Pic::orderBy('nama', 'asc')->get();

        return view('daftar-pantau.kepemimpinan.edit_kepesertaan', compact('item', 'jenisPantau', 'pics'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $item = DaftarPantauKepesertaan::findOrFail($id);

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
            $data['lampiran'] = $request->file('lampiran')->store('lampiran/kepesertaan', 'public');
        }

        $item->update($data);

        return redirect()->route('daftar-pantau.kepemimpinan.show', $item->kelas_kepemimpinan_id)
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        $item = DaftarPantauKepesertaan::findOrFail($id);
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