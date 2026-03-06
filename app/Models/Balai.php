<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Balai extends Model
{
    use HasFactory;

    protected $table = 'tb_balai';

    protected $fillable = [
        'nama_balai',
        'keterangan',
    ];

    public function kelasKepemimpinan()
    {
        return $this->hasMany(KelasKepemimpinan::class, 'balai_id');
    }

    public function kelasFungsional()
    {
        return $this->hasMany(KelasFungsional::class, 'balai_id');
    }
}
