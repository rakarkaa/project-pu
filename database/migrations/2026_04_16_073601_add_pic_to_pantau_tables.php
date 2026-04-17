<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->string('pic')->after('pejabat_ttd')->nullable();
        });

        Schema::table('daftar_pantau_kepesertaanfung', function (Blueprint $table) {
            $table->string('pic')->after('pejabat_ttd')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->dropColumn('pic');
        });

        Schema::table('daftar_pantau_kepesertaanfung', function (Blueprint $table) {
            $table->dropColumn('pic');
        });
    }
};