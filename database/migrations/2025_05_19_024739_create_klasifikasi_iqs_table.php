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
        Schema::create('klasifikasi_iqs', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedTinyInteger('iq_min'); // Nilai minimum dari rentang IQ
            $table->unsignedTinyInteger('iq_max')->nullable(); // Nilai maksimum, nullable untuk nilai 'up'
            $table->string('klasifikasi'); // Misal: GENIUS, VERY SUPERIOR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klasifikasi_iqs');
    }
};
