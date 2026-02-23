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
        'total_peserta' => 'required|integer',
        'jenis_pantau'  => 'required|string',
        'keterangan'    => 'required|string',
        'deadline_hari' => 'nullable|integer',
        'tujuan'        => 'required|string',
        'lampiran'      => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
    ]);

    $kelas = KelasKepemimpinan::findOrFail($kelasId);

    // $deadlinePantau = Carbon::parse($kelas->tanggal_mulai)
    //     ->addDays((int) $request->deadline_hari);

    $lampiranPath = null;
    if ($request->hasFile('lampiran')) {
        $lampiranPath = $request->file('lampiran')
            ->store('lampiran/kepesertaan', 'public');
    }

    DaftarPantauKepesertaan::create([
        'kelas_kepemimpinan_id' => $kelas->id,
        'total_peserta'         => $request->total_peserta,
        'jenis_pantau'          => $request->jenis_pantau,
        'deadline_hari'         => 0,
        'deadline_pantau'       => now(),
        'status_pantau'         => 'pending',
        'keterangan'            => $request->keterangan,
        'tujuan'                => $request->tujuan,
        'lampiran'              => $lampiranPath,
    ]);

    return back()->with('success', 'Daftar pantau kepesertaan berhasil ditambahkan');
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

public function update(Request $request, $id)
{
    $data = DaftarPantauKepesertaan::findOrFail($id);

    $request->validate([
        'total_peserta' => 'required|integer',
        'jenis_pantau'  => 'required|string',
        'keterangan'    => 'required|string',
        'tujuan'        => 'required|string',
        'lampiran'      => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
    ]);

    // siapkan array update dulu
    $updateData = [
        'total_peserta' => $request->total_peserta,
        'jenis_pantau'  => $request->jenis_pantau,
        'keterangan'    => $request->keterangan,
        'tujuan'        => $request->tujuan,
    ];

    if ($request->hasFile('lampiran')) {

        // hapus file lama
        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        // simpan file baru
        $updateData['lampiran'] = $request->file('lampiran')
            ->store('lampiran/kepesertaan','public');
    }

    // update sekali saja
    $data->update($updateData);

    return back()->with('success','Data berhasil diupdate');
}

}
