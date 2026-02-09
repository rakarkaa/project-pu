<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPantauPengajarFung extends Model
{
   protected $table = 'daftar_pantau_pengajarfung';

    protected $fillable = [
        'kelas_fungsional_id',
        'daftar_pengajar',
        'jenis_pantau',
        'deadline_hari',
        'deadline_pantau',
        'status_pantau',
        'tujuan',
        'lampiran',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasFungsional::class, 'kelas_fungsional_id');
    }
}
