<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MargeUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('merge_ujian')->insert([
            [
                'kode' => 'merge_ujian_1',
                'nama' => 'Tes Kepribadian',
                'jenis' => 1,
                'kelas_id' => 1,
                'jam' => 1,
                'menit' => 30,
                'acak' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode' => 'tes_merge_ujian_2',
                'nama' => 'Ujian Contoh',
                'jenis' => 2,
                'kelas_id' => 2,
                'jam' => 2,
                'menit' => 0,
                'acak' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
