<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            // Menambahkan kolom keterangan_dua setelah kolom keterangan
            // Dibuat nullable() agar data yang sudah ada sebelumnya tidak error
            $table->string('keterangan_dua')->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->dropColumn('keterangan_dua');
        });
    }
};