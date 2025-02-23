<?php

namespace Database\Seeders;

use App\Models\DetailEssay;
use App\Models\JawabanEssay;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part3 = [
            1 => 10,
            2 => 6,
            3 => 5,
            4 => 17,
            5 => 15,
            6 => 9,
            7 => 280,
            8 => 48,
            9 => 230,
            10 => 3.5,
            11 => 186,
            12 => 600,
            13 => 47,
            14 => 48.5,
            15 => 51,
            16 => 72,
            17 => 23100
        ];
        $kode = 'part3';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 3',
            'jenis' => 1, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'nilai_tambahan' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $tespart3 = 'tespart3';
        DB::table('ujian')->insert([
            'kode' => $tespart3,
            'nama' => 'Part 3',
            'jenis' => 1, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 2, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 2, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'nilai_tambahan' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        
        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.jpg',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_ujian' => $tespart3,
                'kode_merge_ujian' => 'tes_merge_ujian_2',
                'banner' => 'banner2.jpg',
                'instruksi_ujian' => 'Pastikan koneksi stabil.',
                'urutan' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        foreach ($part3 as $number => $answer) { 
            $detailEssy = DetailEssay::create([
                'kode' => $kode,
                'soal' => 'Soal ' . $number, 
                'type_kunci_jawaban' => "number",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
 
            JawabanEssay::create([
                'detail_essay_id' => $detailEssy->id,
                'jawaban' => $answer,
                'nilai' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $counter = 0;
        foreach ($part3 as $number => $answer) { 
            if ($counter >= 3) break;
            $counter++;
            $detailEssy = DetailEssay::create([
                'kode' => $tespart3,
                'soal' => 'Soal ' . $number, 
                'type_kunci_jawaban' => "number",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
 
            JawabanEssay::create([
                'detail_essay_id' => $detailEssy->id,
                'jawaban' => $answer,
                'nilai' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
