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
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'keterangan',
        'keterangan_dua',
        'pejabat_ttd',
        'pic',              // <-- INI KUNCI UTAMANYA
        'batas_waktu', 
        'tujuan',
        'lampiran',
    ];

    /**
     * Relasi ke Kelas Fungsional
     */
    public function kelas()
    {
        return $this->belongsTo(KelasFungsional::class, 'kelas_fungsional_id');
    }
}