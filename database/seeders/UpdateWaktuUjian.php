<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateWaktuUjian extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parts = [
            [
                'code_part' => 'part1_1',
                'nama_part' => 'Part 1.1',
                'jumlah_soal' => 13,
                'durasi_menit' => 3
            ],
            [
                'code_part' => 'part1_2',
                'nama_part' => 'Part 1.2',
                'jumlah_soal' => 14,
                'durasi_menit' => 4
            ],
            [
                'code_part' => 'part1_3',
                'nama_part' => 'Part 1.3',
                'jumlah_soal' => 13,
                'durasi_menit' => 3
            ],
            [
                'code_part' => 'part1_4',
                'nama_part' => 'Part 1.4',
                'jumlah_soal' => 10,
                'durasi_menit' => 2.5
            ],
            [
                'code_part' => 'part2',
                'nama_part' => 'Part 2',
                'jumlah_soal' => 26,
                'durasi_menit' => 9
            ],
            [
                'code_part' => 'part3',
                'nama_part' => 'Part 3',
                'jumlah_soal' => 17,
                'durasi_menit' => 6
            ],
            [
                'code_part' => 'part4',
                'nama_part' => 'Part 4',
                'jumlah_soal' => 18,
                'durasi_menit' => 6.5
            ],
        ];
        foreach ($parts as $part) {
            DB::table('ujian')->where('kode', $part['code_part'])->update([
                'jam' => 0,
                'menit' => $part['durasi_menit'],  
            ]);
        }
        
    }
}
