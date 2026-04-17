<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolaPenyelenggaraan extends Model
{
    use HasFactory;

    protected $table = 'tb_pola_penyelenggaraan';

    protected $fillable = [
        'penyelenggara',
    ];
}