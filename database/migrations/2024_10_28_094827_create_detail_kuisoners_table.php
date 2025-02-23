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
        Schema::create('detail_kuisoner', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255); 
            $table->string('item', 255)->nullable();
            $table->string('jawaban', 255)->nullable();
            $table->unsignedBigInteger('jenis_jawaban_kuesioner_id');
            $table->longText('soal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kuisoners');
    }
};
