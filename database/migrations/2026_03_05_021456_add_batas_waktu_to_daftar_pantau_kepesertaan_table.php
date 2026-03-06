<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            // Kita gunakan tipe 'date' karena ini untuk input tanggal kalender
            $table->date('batas_waktu')->nullable()->after('pejabat_ttd');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->dropColumn('batas_waktu');
        });
    }
};