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
        Schema::create('essay_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_ujian_id');
            $table->string('kode');
            $table->unsignedBigInteger('siswa_id');
            $table->longText('jawaban')->nullable();
            $table->boolean('ragu')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });

        // Foreign keys
        // $table->foreign('detail_ujian_id')->references('id')->on('detail_ujian')->onDelete('cascade');
        // $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('essay_siswa');
    }
};
