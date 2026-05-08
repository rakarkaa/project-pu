<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tujuan_penerima_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unitorganisasi'); 
            $table->string('nama_unitkerja');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tujuan_penerima_surat');
    }
};