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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique()->nullable();
            $table->string('nama_siswa');
            $table->string('gender');
            $table->unsignedBigInteger('kelas_id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar');
            $table->integer('role');
            $table->boolean('is_active');
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
