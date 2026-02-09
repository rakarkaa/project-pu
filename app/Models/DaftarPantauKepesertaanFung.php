<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPantauKepesertaanFung extends Model
{
    use HasFactory;

    protected $table = 'daftar_pantau_kepesertaanfung';

    protected $fillable = [
        'kelas_fungsional_id',
        'total_peserta',
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'tujuan',
        'lampiran',
    ];

    /**
     * Relasi ke Kelas Kepemimpinan
     */
    public function kelas()
    {
        return $this->belongsTo(KelasFungsional::class, 'kelas_fungsional_id');
    }
}
