<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmailSettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('email_settings')->insert([
            'notif_akun' => 1,
            'notif_materi' => 1,
            'notif_tugas' => 1,
            'notif_ujian' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
