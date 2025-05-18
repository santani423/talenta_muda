<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlasifikasiIqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('klasifikasi_iqs')->insert([
            [
                'iq_min' => 170,
                'iq_max' => null,
                'klasifikasi' => 'GENIUS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 140,
                'iq_max' => 169,
                'klasifikasi' => 'VERY SUPERIOR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 120,
                'iq_max' => 139,
                'klasifikasi' => 'SUPERIOR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 110,
                'iq_max' => 119,
                'klasifikasi' => 'HIGH AVERAGE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 90,
                'iq_max' => 109,
                'klasifikasi' => 'AVERAGE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 80,
                'iq_max' => 89,
                'klasifikasi' => 'LOW AVERAGE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 70,
                'iq_max' => 79,
                'klasifikasi' => 'BORDERLINE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iq_min' => 30,
                'iq_max' => 69,
                'klasifikasi' => 'MENTALLY DEFECTIVE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

// php artisan db:seed --class=KlasifikasiIqSeeder
