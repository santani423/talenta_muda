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
        Schema::create('kuesioner_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id'); // ID siswa
            $table->string('kode')->nullable(); // ID siswa
            $table->string('detail_kuisoner')->nullable(); // ID siswa
            $table->string('nilai')->nullable(); 
            $table->unsignedBigInteger('jenis_jawaban_kuesioner_id')->nullable(); // ID siswa
            $table->unsignedBigInteger('detail_jawaban_kuesioner_id')->nullable(); // ID siswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner_siswas');
    }
};
