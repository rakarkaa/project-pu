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
}
