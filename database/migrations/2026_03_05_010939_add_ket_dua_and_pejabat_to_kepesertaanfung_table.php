<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pantau_kepesertaanfung', function (Blueprint $table) {
            $table->text('keterangan_dua')->nullable()->after('keterangan');
            $table->string('pejabat_ttd')->nullable()->after('keterangan_dua');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pantau_kepesertaanfung', function (Blueprint $table) {
            $table->dropColumn(['keterangan_dua', 'pejabat_ttd']);
        });
    }
};