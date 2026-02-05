<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daftar_pantau_kepesertaan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_kepemimpinan_id')
                ->constrained('kelas_kepemimpinan')
                ->cascadeOnDelete();

            $table->integer('total_peserta');

            $table->string('jenis_pantau');

            // jumlah hari dari tanggal mulai pelatihan
            $table->integer('deadline_hari');

            // hasil perhitungan dari tanggal_mulai + deadline_hari
            $table->date('deadline_pantau');

            $table->string('status_pantau')->default('pending');

            $table->string('tujuan');

            $table->string('lampiran')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_pantau_kepesertaan');
    }
};
