<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Menambah kolom angkatan ke tabel kepemimpinan
        Schema::table('kelas_kepemimpinan', function (Blueprint $table) {
            $table->string('angkatan')->nullable()->after('pelatihan_id');
        });

        // Menambah kolom angkatan ke tabel fungsional
        Schema::table('kelas_fungsional', function (Blueprint $table) {
            $table->string('angkatan')->nullable()->after('pelatihan_id');
        });
    }

    public function down()
    {
        Schema::table('kelas_kepemimpinan', function (Blueprint $table) {
            $table->dropColumn('angkatan');
        });

        Schema::table('kelas_fungsional', function (Blueprint $table) {
            $table->dropColumn('angkatan');
        });
    }
};