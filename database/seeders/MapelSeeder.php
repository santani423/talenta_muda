<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapels = [
            ['nama_mapel' => 'Psikotes 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_mapel' => 'Psikotes 2', 'created_at' => now(), 'updated_at' => now()],
            ['nama_mapel' => 'Psikotes 3', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('mapel')->insert($mapels);
    }
}
