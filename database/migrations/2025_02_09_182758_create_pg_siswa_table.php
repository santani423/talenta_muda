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
        Schema::create('pg_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_ujian_id');
            $table->string('kode', 255);
            $table->unsignedBigInteger('siswa_id');
            $table->string('jawaban', 255)->nullable();
            $table->boolean('benar')->nullable();
            $table->boolean('ragu')->nullable();
            $table->string('nilai', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_siswa');
    }
};
