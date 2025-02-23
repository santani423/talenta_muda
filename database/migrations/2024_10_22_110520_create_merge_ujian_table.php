<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMergeUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merge_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255);
            $table->string('nama', 255);
            $table->integer('jenis'); 
            $table->integer('kelas_id'); 
            $table->integer('jam')->nullable();
            $table->integer('menit')->nullable();
            $table->integer('acak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merge_ujian');
    }
}
