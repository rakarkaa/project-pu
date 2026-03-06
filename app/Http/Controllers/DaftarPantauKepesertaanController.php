<?php

namespace App\Http\Controllers;

use App\Models\DaftarPantauKepesertaan;
use App\Models\KelasKepemimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DaftarPantauKepesertaanController extends Controller
{
    /**
     * Store data kepesertaan
     */
    public function store(Request $request, $kelasId)
    {
        $request->validate([
            'total_peserta'  => 'required|integer',
            'jenis_pantau'   => 'required|string',
            'keterangan'     => 'required|string',
            'keterangan_dua' => 'nullable|string',
            'pejabat_ttd'    => 'required|string|in:Kepala Pusat,Kepala BPSDM',
            'batas_waktu'    => 'nullable|integer|min:0', // <-- UBAH JADI INTEGER
            'deadline_hari'  => 'nullable|integer',
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $kelas = KelasKepemimpinan::findOrFail($kelasId);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran/kepesertaan', 'public');
        }

        // Konversi angka hari menjadi Tanggal asli
        $batasWaktuDate = $request->filled('batas_waktu') 
            ? \Carbon\Carbon::now()->addDays((int) $request->batas_waktu)->format('Y-m-d') 
            : null;

        DaftarPantauKepesertaan::create([
            'kelas_kepemimpinan_id' => $kelas->id,
            'total_peserta'         => $request->total_peserta,
            'jenis_pantau'          => $request->jenis_pantau,
            'deadline_hari'         => 0,
            'deadline_pantau'       => now(),
            'status_pantau'         => 'pending',
            'keterangan'            => $request->keterangan,
            'keterangan_dua'        => $request->keterangan_dua,
            'pejabat_ttd'           => $request->pejabat_ttd,
            'batas_waktu'           => $batasWaktuDate, // <-- SIMPAN TANGGALNYA
            'tujuan'                => $request->tujuan,
            'lampiran'              => $lampiranPath,
        ]);

        return back()->with('success', 'Daftar pantau kepesertaan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = DaftarPantauKepesertaan::findOrFail($id);
        // Panggil master Jenis Pantau untuk form select
        $jenisPantau = \App\Models\JenisPantau::orderBy('nama_pantau', 'asc')->get();
        
        return view('daftar-pantau.kepemimpinan.edit', compact('item', 'jenisPantau'));
    }

    public function update(Request $request, $id)
    {
        $data = DaftarPantauKepesertaan::findOrFail($id);

        $request->validate([
            'total_peserta'  => 'required|integer',
            'jenis_pantau'   => 'required|string',
            'keterangan'     => 'required|string',
            'keterangan_dua' => 'nullable|string',
            'pejabat_ttd'    => 'required|string|in:Kepala Pusat,Kepala BPSDM',
            'batas_waktu'    => 'nullable|integer|min:0', // <-- UBAH JADI INTEGER
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        // Konversi angka hari menjadi Tanggal asli
        $batasWaktuDate = $request->filled('batas_waktu') 
            ? \Carbon\Carbon::now()->addDays((int) $request->batas_waktu)->format('Y-m-d') 
            : null;

        $updateData = [
            'total_peserta'  => $request->total_peserta,
            'jenis_pantau'   => $request->jenis_pantau,
            'keterangan'     => $request->keterangan,
            'keterangan_dua' => $request->keterangan_dua,
            'pejabat_ttd'    => $request->pejabat_ttd,
            'batas_waktu'    => $batasWaktuDate, // <-- UPDATE TANGGALNYA
            'tujuan'         => $request->tujuan,
        ];

        if ($request->hasFile('lampiran')) {
            if ($data->lampiran) { \Illuminate\Support\Facades\Storage::disk('public')->delete($data->lampiran); }
            $updateData['lampiran'] = $request->file('lampiran')->store('lampiran/kepesertaan', 'public');
        }

        $data->update($updateData);

        // ==========================================
        // PERBAIKAN: Ubah return back() menjadi redirect()
        // ==========================================
        return redirect()->route('daftar-pantau.kepemimpinan.show', $data->kelas_kepemimpinan_id)
            ->with('success', 'Data pemantauan berhasil diupdate!');
    }

    /**
     * Delete data kepesertaan
     */
    public function destroy($id)
    {
        $data = DaftarPantauKepesertaan::findOrFail($id);

        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        $data->delete();

        return back()->with('success', 'Data kepesertaan berhasil dihapus');
    }

}
