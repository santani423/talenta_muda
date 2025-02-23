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
        Schema::create('simulasi_ujian_visual', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255);
            $table->longText('soal');
            $table->string('pg_1', 255)->nullable();
            $table->string('pg_2', 255)->nullable();
            $table->string('pg_3', 255)->nullable();
            $table->string('pg_4', 255)->nullable();
            $table->string('pg_5', 255)->nullable();
            $table->string('pg_6', 255)->nullable();
            $table->string('jawaban_1', 255);
            $table->string('jawaban_2', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi_ujian_visual');
    }
};
