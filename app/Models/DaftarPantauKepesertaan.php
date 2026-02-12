<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPantauKepesertaan extends Model
{
    use HasFactory;

    protected $table = 'daftar_pantau_kepesertaan';

    protected $fillable = [
        'kelas_kepemimpinan_id',
        'total_peserta',
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'keterangan',
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
