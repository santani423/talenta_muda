<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuMulaiToWaktuUjianTable extends Migration
{
    public function up()
    {
        Schema::table('waktu_ujian', function (Blueprint $table) {
            $table->string('waktu_mulai')->nullable()->after('siswa_id');
        });
    }

    public function down()
    {
        Schema::table('waktu_ujian', function (Blueprint $table) {
            $table->dropColumn('waktu_mulai');
        });
    }
}
