<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DaftarPantauKepesertaan extends Model
{
    use HasFactory;

    protected $table = 'daftar_pantau_kepesertaan';

    protected $fillable = [
        'kelas_kepemimpinan_id',
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'keterangan',
        'keterangan_dua',
        'pejabat_ttd', 
        'pic',           // <-- TAMBAHKAN PIC DI SINI
        'batas_waktu', 
        'tujuan',
        'lampiran',
    ];

    /**
     * Relasi ke Kelas Kepemimpinan
     */
    public function kelas()
    {
        return $this->belongsTo(KelasKepemimpinan::class, 'kelas_kepemimpinan_id');
    }
}