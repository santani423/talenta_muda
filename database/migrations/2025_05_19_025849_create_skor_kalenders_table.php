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
            $table->string('total_raw_score'); 
            $table->string('usia_dari_tahun'); 
            $table->string('usia_dari_bulan');  
            $table->string('usia_sampai_tahun');
            $table->string('usia_sampai_bulan');
            $table->string('nilai');  
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
