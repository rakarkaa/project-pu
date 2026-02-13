<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPantauManajemenFung extends Model
{
    protected $table = 'daftar_pantau_manajemenfung';

    protected $fillable = [
        'kelas_fungsional_id',
        'perihal_manajemen',
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'keterangan',
        'tujuan',
        'lampiran',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasFungsional::class, 'kelas_fungsional_id');
    }
}
