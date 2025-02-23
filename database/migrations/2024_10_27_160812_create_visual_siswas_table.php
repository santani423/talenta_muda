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
        Schema::create('visual_siswa', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('siswa_id'); // ID siswa
            $table->unsignedBigInteger('detail_visual_id'); // ID soal dari tabel detail_visual
            $table->string('kode'); // Menyimpan indeks gambar pertama yang benar
            $table->string('nilai')->nullable(); // Menyimpan indeks gambar pertama yang benar
            $table->string('jawaban_1')->nullable(); // Menyimpan indeks gambar pertama yang benar
            $table->string('jawaban_2')->nullable(); // Menyimpan indeks gambar kedua yang benar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visual_siswas');
    }
};
