<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kelas_fungsional', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelatihan_id')
                ->constrained('tb_pelatihan')
                ->cascadeOnDelete();

            $table->string('balai');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_fungsional');
    }
};
