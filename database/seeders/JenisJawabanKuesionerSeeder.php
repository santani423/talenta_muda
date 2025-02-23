<?php

namespace Database\Seeders;

use App\Models\JenisJawabanKuesioner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisJawabanKuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisJawabanKuesioner::create([
            'kode' => 'JK001',
            'nama_kuesioner' => 'Kuesioner Tingkat Persetujuan',
        ]);
        JenisJawabanKuesioner::create([
            'kode' => 'JK002',
            'nama_kuesioner' => 'Kuesioner Benar/Salah',
        ]);
    }
}
