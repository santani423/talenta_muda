<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailJawabanKuisoner extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_jawaban_kuesioner')->insert([
            [
                'kode' => 'STS',
                'jenis_jawaban_kuesioner_id' => 1,
                'pilihan_kuesioner' => 'Sangat Tidak Setuju',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TS',
                'jenis_jawaban_kuesioner_id' => 1,
                'pilihan_kuesioner' => 'Tidak Setuju',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'N',
                'jenis_jawaban_kuesioner_id' => 1,
                'pilihan_kuesioner' => 'Netral',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'S',
                'jenis_jawaban_kuesioner_id' => 1,
                'pilihan_kuesioner' => 'Setuju',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SS',
                'jenis_jawaban_kuesioner_id' => 1,
                'pilihan_kuesioner' => 'Sangat Setuju',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'B',
                'jenis_jawaban_kuesioner_id' => 2,
                'pilihan_kuesioner' => 'Benar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'S',
                'jenis_jawaban_kuesioner_id' => 2,
                'pilihan_kuesioner' => 'Salah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
