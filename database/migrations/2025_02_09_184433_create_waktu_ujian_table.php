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
        Schema::create('waktu_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->unsignedBigInteger('siswa_id');
            $table->string('waktu_berakhir')->nullable();
            $table->tinyInteger('selesai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_ujian');
    }
};
