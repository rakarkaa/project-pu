<?php

namespace App\Http\Controllers;

use App\Models\DaftarPantauManajemenFung;
use App\Models\KelasFungsional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DaftarPantauManajemenFungController extends Controller
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

        $kelas = KelasFungsional::findOrFail($kelasId);

        $deadlinePantau = Carbon::parse($kelas->tanggal_mulai)
                                ->addDays((int)$request->deadline_hari);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')
                ->store('lampiran/manajemen', 'public');
        }

        DaftarPantauManajemenFung::create([
            'kelas_fungsional_id' => $kelas->id,
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
        $data = DaftarPantauManajemenFung::findOrFail($id);

        if ($data->lampiran) {
            Storage::disk('public')->delete($data->lampiran);
        }

        $data->delete();

        return back()->with('success', 'Data manajemen berhasil dihapus');
    }
}
