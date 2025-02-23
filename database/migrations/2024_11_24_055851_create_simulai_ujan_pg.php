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
        Schema::create('simulai_ujan_pg', function (Blueprint $table) {
            $table->id(); // bigint(20) unsigned, primary key, auto_increment
            $table->string('kode', 255); // varchar(255)
            $table->longText('soal'); // longtext
            $table->string('pg_1', 255)->nullable(); // varchar(255)
            $table->string('pg_2', 255)->nullable();; // varchar(255)
            $table->string('pg_3', 255)->nullable();; // varchar(255)
            $table->string('pg_4', 255)->nullable();; // varchar(255)
            $table->string('pg_5', 255)->nullable();; // varchar(255)
            $table->string('pg_6', 255)->nullable();; // varchar(255)
            $table->string('jawaban', 255); // varchar(255)
            $table->timestamps(); // created_at and updated_at as timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulai_ujan_pg');
    }
};
