<?php

namespace App\Http\Controllers;

use App\Models\DaftarPantauManajemen;
use App\Models\KelasKepemimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DaftarPantauManajemenController extends Controller
{
    public function store(Request $request, $kelasId)
    {
        $request->validate([
            'jenis_pantau'  => 'required',
            'perihal_manajemen' => 'required|string',
            'deadline_hari' => 'required|integer',
            'tujuan'        => 'required',
            'lampiran'      => 'nullable|file',
        ]);

        $kelas = KelasKepemimpinan::findOrFail($kelasId);

        $deadlinePantau = Carbon::parse($kelas->tanggal_mulai)
                                ->addDays((int)$request->deadline_hari);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')
                ->store('lampiran/manajemen', 'public');
        }

        DaftarPantauManajemen::create([
            'kelas_kepemimpinan_id' => $kelas->id,
            'perihal_manajemen'     => $request->perihal_manajemen,
            'jenis_pantau'          => $request->jenis_pantau,
            'deadline_hari'         => $request->deadline_hari,
            'deadline_pantau'       => $deadlinePantau,
            'status_pantau'         => 'pending',
            'tujuan'                => $request->tujuan,
            'lampiran'              => $lampiran,
        ]);

        return back()->with('success', 'Daftar pantau manajemen berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $data = DaftarPantauManajemen::findOrFail($id);

        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        $data->delete();

        return back()->with('success', 'Data manajemen berhasil dihapus');
    }
}

