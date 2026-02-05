<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPantauManajemen extends Model
{
    protected $table = 'daftar_pantau_manajemen';

    protected $fillable = [
        'kelas_kepemimpinan_id',
        'perihal_manajemen',
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'tujuan',
        'lampiran',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasKepemimpinan::class, 'kelas_kepemimpinan_id');
    }
}
