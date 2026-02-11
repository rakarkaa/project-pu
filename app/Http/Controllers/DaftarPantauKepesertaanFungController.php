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
     * Store data kepesertaan
     */
public function store(Request $request, $kelasId)
{
    $request->validate([
        'total_peserta' => 'required|integer',
        'jenis_pantau'  => 'required|string',
        'deadline_hari' => 'required|integer',
        'tujuan'        => 'required|string',
        'lampiran'      => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
    ]);

    $kelas = KelasFungsional::findOrFail($kelasId);

    $deadlinePantau = Carbon::parse($kelas->tanggal_mulai)
        ->addDays((int) $request->deadline_hari);

    $lampiranPath = null;
    if ($request->hasFile('lampiran')) {
        $lampiranPath = $request->file('lampiran')
            ->store('lampiran/kepesertaan', 'public');
    }

    DaftarPantauKepesertaanFung::create([
        'kelas_fungsional_id' => $kelas->id,
        'total_peserta'         => $request->total_peserta,
        'jenis_pantau'          => $request->jenis_pantau,
        'deadline_hari'         => $request->deadline_hari,
        'deadline_pantau'       => $deadlinePantau,
        'status_pantau'         => 'pending',
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
        $data = DaftarPantauKepesertaanFung::findOrFail($id);

        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        $data->delete();

        return back()->with('success', 'Data kepesertaan berhasil dihapus');
    }
}
