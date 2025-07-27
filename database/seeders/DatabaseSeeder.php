<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            GuruSeeder::class, 
            KelasSeeder::class,
            MapelSeeder::class,
            GuruKelasSeeder::class,
            GuruMapelSeeder::class,
            JenisJawabanKuesionerSeeder::class,
            SekalaSeeder::class,
            MargeUjianSeeder::class,
            DetailJawabanKuisoner::class,
            FacetSeeder::class,
            DomainSeeder::class,
            EmailSettingsSeeder::class,
        ]);

        $this->call([
            Part1_1Seeder::class,  
            Part1_2Seeder::class,  
            Part1_3Seeder::class,  
            Part1_4Seeder::class,  
            Part2Seeder::class,  
            Part3Seeder::class,  
            Part4Seeder::class,  
            Part5_1Seeder::class,  
            Part5_2Seeder::class,  
            Part5_3Seeder::class,  
        ]);

        $this->call([
            // SiswaSeeder::class,   
            // WaktuUjianSeeder::class,   
        ]);
    }
}
// php artisan migrate:fresh --seed
