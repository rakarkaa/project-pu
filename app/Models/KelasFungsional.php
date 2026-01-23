<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasFungsional extends Model
{
    use HasFactory;

    protected $table = 'kelas_fungsional';

    protected $fillable = [
        'pelatihan_id',
        'balai',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    /**
     * Relasi ke Master Pelatihan
     */
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id');
    }
}
