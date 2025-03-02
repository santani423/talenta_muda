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
        Schema::create('simulasi_ujian_essays', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255); // varchar(255)
            $table->longText('soal'); // longtext
            $table->string('jawaban', 255); // varchar(255)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi_ujian_essays');
    }
};
