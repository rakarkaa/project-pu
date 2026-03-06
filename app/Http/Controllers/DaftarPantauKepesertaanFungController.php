<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasFungsional;
use App\Models\DaftarPantauKepesertaanFung;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DaftarPantauKepesertaanFungController extends Controller
{
 public function store(Request $request, $kelasId)
    {
        $request->validate([
            'total_peserta'  => 'required|integer',
            'jenis_pantau'   => 'required|string',
            'keterangan'     => 'required|string',
            'keterangan_dua' => 'nullable|string',
            'pejabat_ttd'    => 'required|string|in:Kepala Pusat,Kepala BPSDM',
            'batas_waktu'    => 'nullable|integer|min:0', 
            'deadline_hari'  => 'nullable|integer',
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $kelas = KelasFungsional::findOrFail($kelasId);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran/kepesertaan_fung', 'public');
        }

        // PERBAIKAN: Tambahkan (int) agar string dari form diubah paksa jadi angka
        $batasWaktuDate = $request->filled('batas_waktu') 
            ? \Carbon\Carbon::now()->addDays((int) $request->batas_waktu)->format('Y-m-d') 
            : null;

        DaftarPantauKepesertaanFung::create([
            'kelas_fungsional_id'   => $kelas->id,
            'total_peserta'         => $request->total_peserta,
            'jenis_pantau'          => $request->jenis_pantau,
            'deadline_hari'         => 0,
            'deadline_pantau'       => now(),
            'status_pantau'         => 'pending',
            'keterangan'            => $request->keterangan,
            'keterangan_dua'        => $request->keterangan_dua,
            'pejabat_ttd'           => $request->pejabat_ttd,
            'batas_waktu'           => $batasWaktuDate, // Tersimpan sebagai tanggal
            'tujuan'                => $request->tujuan,
            'lampiran'              => $lampiranPath,
        ]);

        return back()->with('success', 'Daftar pantau kepesertaan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = \App\Models\DaftarPantauKepesertaanFung::findOrFail($id);
        $jenisPantau = \App\Models\JenisPantau::orderBy('nama_pantau', 'asc')->get();
        
        return view('daftar-pantau.fungsional.edit', compact('item', 'jenisPantau'));
    }

public function update(Request $request, $id)
    {
        // 1. Cari data berdasarkan ID
        $data = \App\Models\DaftarPantauKepesertaanFung::findOrFail($id);

        // 2. Validasi input dari form edit
        $request->validate([
            'total_peserta'  => 'required|integer',
            'jenis_pantau'   => 'required|string',
            'keterangan'     => 'required|string',
            'keterangan_dua' => 'nullable|string',
            'pejabat_ttd'    => 'required|string|in:Kepala Pusat,Kepala BPSDM',
            'batas_waktu'    => 'nullable|integer|min:0',
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        // 3. Konversi angka batas waktu kembali menjadi format Tanggal (Y-m-d)
        $batasWaktuDate = $request->filled('batas_waktu') 
            ? \Carbon\Carbon::now()->addDays((int) $request->batas_waktu)->format('Y-m-d') 
            : null;

        // 4. Siapkan array data yang akan diupdate
        $updateData = [
            'total_peserta'  => $request->total_peserta,
            'jenis_pantau'   => $request->jenis_pantau,
            'keterangan'     => $request->keterangan,
            'keterangan_dua' => $request->keterangan_dua,
            'pejabat_ttd'    => $request->pejabat_ttd,
            'batas_waktu'    => $batasWaktuDate,
            'tujuan'         => $request->tujuan,
        ];

        // 5. Cek jika ada upload file lampiran baru
        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($data->lampiran) { 
                \Illuminate\Support\Facades\Storage::disk('public')->delete($data->lampiran); 
            }
            // Simpan file baru
            $updateData['lampiran'] = $request->file('lampiran')->store('lampiran/kepesertaan_fung', 'public');
        }

        // 6. EKSEKUSI UPDATE KE DATABASE (Ini yang paling penting!)
        $data->update($updateData);

        // 7. Redirect kembali ke halaman show dengan pesan sukses
        return redirect()->route('daftar-pantau.fungsional.show', $data->kelas_fungsional_id)
            ->with('success', 'Data pemantauan fungsional berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $data = DaftarPantauKepesertaanFung::findOrFail($id);
        if ($data->lampiran) { Storage::disk('public')->delete($data->lampiran); }
        $data->delete();

        return back()->with('success', 'Data kepesertaan berhasil dihapus');
    }
}