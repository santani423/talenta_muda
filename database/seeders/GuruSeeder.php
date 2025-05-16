<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('guru')->insert([
            [
                'nama_guru' => 'Egi',
                'gender' => 'Laki-laki',
                'email' => 'egi.suni@gmail.com',
                'password' => bcrypt('123'),
                'avatar' => 'jxDMpVvTA1ue7Xp6bSfnbRRH3xGKxDuV2I9hVEFB.png',
                'role' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_guru' => 'Lena',
                'gender' => 'Perempuan',
                'email' => 'siti.aminah@gmail.com',
                'password' => bcrypt('123'),
                'avatar' => 'wqqzHdJXSx1umRxkPRKlkdmRrFvxqK8uOA7KbVoJ.jpg',
                'role' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
        ]);
        DB::table('admins')->insert([
            [
                'nama_admin' => 'admin', 
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123'),
                'avatar' => 'wqqzHdJXSx1umRxkPRKlkdmRrFvxqK8uOA7KbVoJ.jpg',
                'role' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
        ]);
    }
}
// php artisan db:seed --class=GuruSeeder