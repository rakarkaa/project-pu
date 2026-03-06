<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            // Ditambahkan setelah keterangan_dua
            $table->string('pejabat_ttd')->nullable()->after('keterangan_dua');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->dropColumn('pejabat_ttd');
        });
    }
};