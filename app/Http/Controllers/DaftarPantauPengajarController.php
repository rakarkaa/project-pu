<?php

namespace App\Http\Controllers;

use App\Models\DaftarPantauPengajar;
use App\Models\KelasKepemimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DaftarPantauPengajarController extends Controller
{
    public function store(Request $request, $kelasId)
    {
        $request->validate([
            'daftar_pengajar' => 'required|string',
            'jenis_pantau'   => 'required|string',
            'deadline_hari'  => 'required|integer',
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $kelas = KelasKepemimpinan::findOrFail($kelasId);

        $deadlinePantau = Carbon::parse($kelas->tanggal_mulai)
            ->addDays((int) $request->deadline_hari);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')
                ->store('lampiran/pengajar', 'public');
        }

        DaftarPantauPengajar::create([
            'kelas_kepemimpinan_id' => $kelas->id,
            'daftar_pengajar'       => $request->daftar_pengajar,
            'jenis_pantau'          => $request->jenis_pantau,
            'deadline_hari'         => $request->deadline_hari,
            'deadline_pantau'       => $deadlinePantau,
            'status_pantau'         => 'pending',
            'tujuan'                => $request->tujuan,
            'lampiran'              => $lampiranPath,
        ]);

        return back()->with('success', 'Daftar pantau pengajar berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $data = DaftarPantauPengajar::findOrFail($id);

        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        $data->delete();

        return back()->with('success', 'Data pengajar berhasil dihapus');
    }
}

