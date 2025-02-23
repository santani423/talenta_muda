<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = [
            ['nama_kelas' => 'Batch 1'],
            ['nama_kelas' => 'Batch 2'],
            ['nama_kelas' => 'Batch 3'],
            ['nama_kelas' => 'Batch 4'],
            ['nama_kelas' => 'Batch 5'],
            ['nama_kelas' => 'Batch 6'],
        ];

        DB::table('kelas')->insert($kelas);
    }
}
