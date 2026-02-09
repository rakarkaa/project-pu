<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
 Schema::create('daftar_pantau_pengajarfung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_fungsional_id')->constrained('kelas_fungsional')->cascadeOnDelete();

            $table->string('daftar_pengajar');
            $table->string('jenis_pantau');
            $table->integer('deadline_hari');
            $table->date('deadline_pantau');
            $table->string('status_pantau')->default('pending');
            $table->string('tujuan');

            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_pantau_pengajarfung');
    }
};
