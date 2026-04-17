<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambah kolom ke tabel kelas_kepemimpinan
        Schema::table('kelas_kepemimpinan', function (Blueprint $table) {
            $table->integer('total_peserta')->after('balai')->default(0);
        });

        // Menambah kolom ke tabel kelas_fungsional
        Schema::table('kelas_fungsional', function (Blueprint $table) {
            $table->integer('total_peserta')->after('balai')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('kelas_kepemimpinan', function (Blueprint $table) {
            $table->dropColumn('total_peserta');
        });

        Schema::table('kelas_fungsional', function (Blueprint $table) {
            $table->dropColumn('total_peserta');
        });
    }
};