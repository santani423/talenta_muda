<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelasiUjianMergeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relasi_ujian_merge', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ujian'); // Menggunakan kode_ujian
            $table->string('kode_merge_ujian'); // Menggunakan kode_merge_ujian
            $table->string('banner', 255)->nullable();
            $table->string('instruksi_ujian', 255)->nullable();
            $table->integer('urutan')->nullable();
            $table->timestamps();

            // Foreign key constraints
            // $table->foreign('kode_ujian')
            //       ->references('kode')
            //       ->on('ujian')
            //       ->onDelete('cascade');

            // $table->foreign('kode_merge_ujian')
            //       ->references('kode')
            //       ->on('merge_ujian')
            //       ->onDelete('cascade');

            // // Unique constraint to prevent duplicate relationships
            // $table->unique(['kode_ujian', 'kode_merge_ujian']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relasi_ujian_merge');
    }
}
