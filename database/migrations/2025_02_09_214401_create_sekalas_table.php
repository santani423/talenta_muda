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
        Schema::create('sekalas', function (Blueprint $table) {
            $table->id();
            $table->string('sekala', 255); 
            $table->string('kode', 255); 
            $table->text('sekala_tinggi'); 
            $table->text('sekala_rendah'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekalas');
    }
};
