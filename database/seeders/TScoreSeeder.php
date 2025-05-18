<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_scores')->insert([
            [
                'ujian_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ujian_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

//  php artisan db:seed --class=TScoreSeeder
//  php artisan db:seed --class=SkorKalender
//  php artisan db:seed --class=KlasifikasiIqSeeder
