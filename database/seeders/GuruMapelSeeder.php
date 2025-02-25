<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuruMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        // for ($i = 1; $i <= 3; $i++) {
        //     $data[] = [
        //         'guru_id' => 1,
        //         'mapel_id' => $i,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ];
        // }

        $data[] = [
            'guru_id' => 1,
            'mapel_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $data[] = [
            'guru_id' => 2,
            'mapel_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('gurumapel')->insert($data);
    }
}
