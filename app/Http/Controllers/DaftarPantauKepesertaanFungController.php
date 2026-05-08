<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasFungsional;
use App\Models\DaftarPantauKepesertaanFung;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DaftarPantauKepesertaanFungController extends Controller
{
    /**
     * Store data kepesertaan fungsional
     */
    public function store(Request $request, $kelasId)
    {
        $request->validate([
            'jenis_pantau'  => 'required|string',
            'status_pantau' => 'required|string', // Dropdown Status baru
            'keterangan'    => 'required|string', // Field keterangan utama
            'pejabat_ttd'   => 'required|string|in:Kepala Pusat,Kepala BPSDM',
            'pic'           => 'required|string', // Field PIC baru
            'batas_waktu'   => 'nullable|integer|min:0', 
            'deadline_hari' => 'nullable|integer',
            'tujuan'        => 'required|array',  // Diubah jadi array karena checkbox
            'tujuan.*'      => 'string',
            'lampiran'      => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $kelas = KelasFungsional::findOrFail($kelasId);

        // Handle Upload Lampiran
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran/kepesertaan_fung', 'public');
        }

        // Konversi angka hari menjadi tanggal asli
        $batasWaktuDate = $request->filled('batas_waktu') 
            ? \Carbon\Carbon::now()->addDays((int) $request->batas_waktu)->format('Y-m-d') 
            : null;

        // Gabungkan checkbox tujuan menjadi string (misal: "Biro, Unit Kerja")
        $tujuanString = $request->has('tujuan') ? implode(', ', $request->tujuan) : null;

        DaftarPantauKepesertaanFung::create([
            'kelas_fungsional_id' => $kelas->id,
            'total_peserta'       => 0, // Default 0 karena inputan dihapus dari form
            'jenis_pantau'        => $request->jenis_pantau,
            'deadline_hari'       => 0,
            'deadline_pantau'     => now(),
            'status_pantau'       => $request->status_pantau,
            'keterangan'          => $request->keterangan,
            'keterangan_dua'      => null, // Diset null karena digabung ke field keterangan
            'pejabat_ttd'         => $request->pejabat_ttd,
            'pic'                 => $request->pic, // Simpan data PIC
            'batas_waktu'         => $batasWaktuDate,
            'tujuan'              => $tujuanString,
            'lampiran'            => $lampiranPath,
        ]);

        return back()->with('success', 'Daftar pantau kepesertaan fungsional berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = \App\Models\DaftarPantauKepesertaanFung::findOrFail($id);
        $jenisPantau = \App\Models\JenisPantau::orderBy('nama_pantau', 'asc')->get();
        // Pastikan variabel $pics juga dikirim ke view edit jika dibutuhkan
        $pics = \App\Models\Pic::all(); // Sesuaikan dengan model PIC kamu
        
        // Mengambil data master tujuan untuk dropdown
        $listTujuan = \App\Models\TujuanPenerimaSurat::all();

        return view('daftar-pantau.fungsional.edit', compact('item', 'jenisPantau', 'pics', 'listTujuan'));
    }

    /**
     * Update data kepesertaan fungsional
     */
    public function update(Request $request, $id)
    {
        $data = \App\Models\DaftarPantauKepesertaanFung::findOrFail($id);

        $request->validate([
            'jenis_pantau'  => 'required|string',
            'status_pantau' => 'required|string',
            'keterangan'    => 'required|string',
            'pejabat_ttd'   => 'required|string|in:Kepala Pusat,Kepala BPSDM',
            'pic'           => 'required|string',
            'batas_waktu'   => 'nullable|integer|min:0',
            'tujuan'        => 'required|array',
            'tujuan.*'      => 'string',
            'lampiran'      => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $batasWaktuDate = $request->filled('batas_waktu') 
            ? \Carbon\Carbon::now()->addDays((int) $request->batas_waktu)->format('Y-m-d') 
            : null;

        $tujuanString = $request->has('tujuan') ? implode(', ', $request->tujuan) : null;

        $updateData = [
            'jenis_pantau'  => $request->jenis_pantau,
            'status_pantau' => $request->status_pantau,
            'keterangan'    => $request->keterangan,
            'pejabat_ttd'   => $request->pejabat_ttd,
            'pic'           => $request->pic,
            'batas_waktu'   => $batasWaktuDate,
            'tujuan'        => $tujuanString,
        ];

        if ($request->hasFile('lampiran')) {
            if ($data->lampiran) { 
                \Illuminate\Support\Facades\Storage::disk('public')->delete($data->lampiran); 
            }
            $updateData['lampiran'] = $request->file('lampiran')->store('lampiran/kepesertaan_fung', 'public');
        }

        $data->update($updateData);

        return redirect()->route('daftar-pantau.fungsional.show', $data->kelas_fungsional_id)
            ->with('success', 'Data pemantauan fungsional berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $data = DaftarPantauKepesertaanFung::findOrFail($id);
        if ($data->lampiran) { Storage::disk('public')->delete($data->lampiran); }
        $data->delete();

        return back()->with('success', 'Data kepesertaan fungsional berhasil dihapus');
    }
}