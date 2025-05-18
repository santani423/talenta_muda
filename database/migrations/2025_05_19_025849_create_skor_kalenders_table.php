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
        Schema::create('skor_kalenders', function (Blueprint $table) {
            $table->id();
            $table->string('total_raw_score'); // 0 - 13
            $table->string('usia_dari_tahun'); // contoh: 13
            $table->string('usia_dari_bulan'); // contoh: 0-11
            $table->string('usia_sampai_tahun');
            $table->string('usia_sampai_bulan');
            $table->string('nilai'); // skor (40-81)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skor_kalenders');
    }
};
