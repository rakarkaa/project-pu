<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPantau extends Model
{
    use HasFactory;

    protected $table = 'jenis_pantau';

    protected $fillable = [
        'nama_pantau',
    ];
}