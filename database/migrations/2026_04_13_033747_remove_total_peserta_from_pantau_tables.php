<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->dropColumn('total_peserta');
        });

        Schema::table('daftar_pantau_kepesertaanfung', function (Blueprint $table) {
            $table->dropColumn('total_peserta');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->integer('total_peserta')->after('kelas_kepemimpinan_id')->nullable();
        });

        Schema::table('daftar_pantau_kepesertaanfung', function (Blueprint $table) {
            $table->integer('total_peserta')->after('kelas_fungsional_id')->nullable();
        });
    }
};