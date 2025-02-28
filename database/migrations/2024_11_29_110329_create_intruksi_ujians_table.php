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
        Schema::create('intruksi_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // Kolom untuk label
            $table->string('label'); // Kolom untuk label
            $table->string('urutan')->nullable(); // Kolom untuk label
            $table->text('intruksi'); // Kolom untuk instruksi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intruksi_ujians');
    }
};
