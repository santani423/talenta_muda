<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MmpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'code' => 'Mt',
                'description' => 'Kode ini digunakan untuk mendeskripsikan level utama atau root dalam struktur hierarki.',
            ],
            [
                'code' => 'TRT',
                'description' => 'Kode ini mewakili elemen top-level dalam struktur yang merupakan cabang utama dari level root.',
            ],
            [
                'code' => 'TRT/TRT1',
                'description' => 'Kode ini mewakili sub-cabang pertama dalam hierarki di bawah elemen TRT.',
            ],
            [
                'code' => 'TRT/TRT2',
                'description' => 'Kode ini mewakili sub-cabang kedua dalam hierarki di bawah elemen TRT.',
            ],
        ];

        DB::table('mmpis')->insert($data);
    }
}
