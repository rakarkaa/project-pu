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
            'keterangan'   => 'required|string',
            'deadline_hari'  => 'nullable|integer',
            'tujuan'         => 'required|string',
            'lampiran'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $kelas = KelasKepemimpinan::findOrFail($kelasId);

        // $deadlinePantau = Carbon::parse($kelas->tanggal_mulai)
        //     ->addDays((int) $request->deadline_hari);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')
                ->store('lampiran/pengajar', 'public');
        }

        DaftarPantauPengajar::create([
            'kelas_kepemimpinan_id' => $kelas->id,
            'daftar_pengajar'       => $request->daftar_pengajar,
            'jenis_pantau'          => $request->jenis_pantau,
            'deadline_hari'         => 0,
            'deadline_pantau'       => now(),
            'status_pantau'         => 'pending',
            'keterangan'            => $request->keterangan,
            'tujuan'                => $request->tujuan,
            'lampiran'              => $lampiranPath,
        ]);

        return back()->with('success', 'Daftar pantau pengajar berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = DaftarPantauPengajar::findOrFail($id);

        $request->validate([
            'daftar_pengajar' => 'required|string',
            'jenis_pantau'    => 'required|string',
            'keterangan'      => 'required|string',
            'tujuan'          => 'required|string',
            'lampiran'        => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $updateData = [
            'daftar_pengajar' => $request->daftar_pengajar,
            'jenis_pantau'    => $request->jenis_pantau,
            'keterangan'      => $request->keterangan,
            'tujuan'          => $request->tujuan,
        ];

        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($data->lampiran) {
                Storage::disk('public')->delete($data->lampiran);
            }
            // Simpan file baru
            $updateData['lampiran'] = $request->file('lampiran')->store('lampiran/pengajar', 'public');
        }

        $data->update($updateData);

        return back()->with('success', 'Data pengajar berhasil diupdate');
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

