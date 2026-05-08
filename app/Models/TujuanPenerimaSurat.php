<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanPenerimaSurat extends Model
{
    use HasFactory;

    protected $table = 'tujuan_penerima_surat';
    
    protected $fillable = [
        'nama_unitorganisasi', 
        'nama_unitkerja'
    ];
}