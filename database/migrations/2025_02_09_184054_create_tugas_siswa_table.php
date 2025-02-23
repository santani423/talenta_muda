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
        Schema::create('tugas_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->unsignedBigInteger('siswa_id');
            $table->longText('teks')->nullable();
            $table->string('file')->nullable();
            $table->string('date_send')->nullable(); // Bisa diubah ke datetime jika ingin lebih fleksibel
            $table->boolean('is_telat')->nullable();
            $table->integer('nilai')->nullable();
            $table->longText('catatan_guru')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_siswa');
    }
};
