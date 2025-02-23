<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuruKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        // for ($i = 1; $i <= 6; $i++) {
        //     $data[] = [
        //         'guru_id' => 1,
        //         'kelas_id' => $i,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ];
        // }

        $data[] = [
            'guru_id' => 1,
            'kelas_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $data[] = [
            'guru_id' => 2,
            'kelas_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('guruKelas')->insert($data);
    }
}
