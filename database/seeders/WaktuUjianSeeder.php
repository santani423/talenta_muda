<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Ujian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaktuUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswa = Siswa::all();

        // foreach ($siswa as $s) {
        //     $ujians = Ujian::where('kelas_id', $s->kelas_id)->get();
        //     foreach ($ujians as $key => $ujian) {
        //         DB::table('waktu_ujian')->insert([
        //             [
        //                 'kode' =>   $ujian->kode,
        //                 'siswa_id' => $s->id,
        //                 'waktu_berakhir' => '2025-12-18 10:54:00',
        //                 'selesai' => 0,
        //                 'created_at' => now(),
        //                 'updated_at' => now(),
        //             ]]);
        //     }
            
        // }
    }
}
