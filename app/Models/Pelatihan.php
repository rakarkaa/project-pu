<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'tb_pelatihan';

    protected $fillable = [
        'nama_pelatihan',
        'jenis_pelatihan',
        'tahun',
        'keterangan',
    ];

    /**
     * Relasi ke Kelas Kepemimpinan
     */
    public function kelasKepemimpinan()
    {
        return $this->hasMany(KelasKepemimpinan::class, 'pelatihan_id');
    }

    public function kelasFungsional()
    {
        return $this->hasMany(KelasFungsional::class, 'pelatihan_id');
    }


}
