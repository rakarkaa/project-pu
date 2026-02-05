<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DaftarPantauKepesertaan;

class KelasKepemimpinan extends Model
{
    use HasFactory;

    protected $table = 'kelas_kepemimpinan';

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

    public function daftarPantauKepesertaan()
    {
        return $this->hasMany(
            DaftarPantauKepesertaan::class,
            'kelas_kepemimpinan_id'
        );
    }

        public function daftarPantauPengajar()
    {
        return $this->hasMany(
            DaftarPantauPengajar::class,
            'kelas_kepemimpinan_id'
        );
    }

}
