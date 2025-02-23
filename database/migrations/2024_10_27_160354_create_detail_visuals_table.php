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
        Schema::create('detail_visual', function (Blueprint $table) {
            $table->id();
            
            $table->string('kode');
            $table->longText('soal');
            $table->string('file_pg_1')->nullable();
            $table->string('pg_1')->default('a');
            $table->string('file_pg_2')->nullable();
            $table->string('pg_2')->default('b');
            $table->string('file_pg_3')->nullable();
            $table->string('pg_3')->default('c');
            $table->string('file_pg_4')->nullable();
            $table->string('pg_4')->default('d');
            $table->string('file_pg_5')->nullable();
            $table->string('pg_5')->default('d');
            $table->string('file_pg_6')->nullable();
            $table->string('pg_6')->default('e');
            $table->string('jawaban_1'); // Menyimpan indeks gambar pertama yang benar
            $table->string('jawaban_2'); // Menyimpan indeks gambar kedua yang benar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_visuals');
    }
};
