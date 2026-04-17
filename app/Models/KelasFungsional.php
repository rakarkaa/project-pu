<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DaftarPantauKepesertaanFung; // <-- PERBAIKAN 1: Mengarah ke model Fungsional yang benar

class KelasFungsional extends Model
{
    use HasFactory;

    protected $table = 'kelas_fungsional';

    protected $fillable = [
        'pelatihan_id',
        'angkatan',
        'balai',
        'pola_penyelenggaraan',
        'total_peserta', // Tambahkan ini
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

    /**
     * PERBAIKAN 2: Ubah nama fungsi dan target class-nya menjadi Fungsional
     */
    public function daftarPantauKepesertaanFung()
    {
        return $this->hasMany(
            DaftarPantauKepesertaanFung::class,
            'kelas_fungsional_id'
        );
    }


}