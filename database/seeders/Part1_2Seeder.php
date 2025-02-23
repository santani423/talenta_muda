<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part1_2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part1_2 = [
            1 => ["a", "c"],
            2 => ["b", "d"],
            3 => ["b", "e"],
            4 => ["b", "d"],
            5 => ["b", "d"],
            6 => ["c", "e"],
            7 => ["a", "d"],
            8 => ["a", "e"],
            9 => ["b", "d"],
            10 => ["b", "d"],
            11 => ["c", "e"],
            12 => ["a", "b"],
            13 => ["b", "e"],
            14 => ["c", "e"]
        ];
        $contoh_part1_2 = [
            1 => ["b", "d"], 
            2 => ["c", "e"], 
        ];
        $kode = 'part1_2';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 1.2 ',
            'jenis' => 3, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $kode_test = 'kode_testpart1_2';
        DB::table('ujian')->insert([
            'kode' => $kode_test,
            'nama' => 'Part 1.2 ',
            'jenis' => 3, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 2, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 2, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.png',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_ujian' => $kode_test,
                'kode_merge_ujian' => 'tes_merge_ujian_2',
                'banner' => 'banner2.png',
                'instruksi_ujian' => 'Pastikan koneksi stabil.',
                'urutan' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        foreach ($part1_2 as $number => $answer) {
            $no = $number++;
            DB::table('detail_visual')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_2/'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_2/'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_2/'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_2/'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_2/'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_2/'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_2/'.$no.'/f.png',
                'jawaban_1' => strtoupper($answer[0]),
                'jawaban_2' => strtoupper($answer[1]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            if ($number == 1) {
                DB::table('simulasi_ujian_visual')->insert([
                    'kode' => $kode,
                    'soal' => 'ujian_seeder/Part1_2/'.$no.'/soal.png',
                    'pg_1' => 'ujian_seeder/Part1_2/'.$no.'/a.png',
                    'pg_2' => 'ujian_seeder/Part1_2/'.$no.'/b.png',
                    'pg_3' => 'ujian_seeder/Part1_2/'.$no.'/c.png',
                    'pg_4' => 'ujian_seeder/Part1_2/'.$no.'/d.png',
                    'pg_5' => 'ujian_seeder/Part1_2/'.$no.'/e.png',
                    'pg_6' => 'ujian_seeder/Part1_2/'.$no.'/f.png',
                    'jawaban_1' => strtoupper($answer[0]),
                    'jawaban_2' => strtoupper($answer[1]),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        $counter = 0;
        $no = 0;
        foreach ($part1_2 as $number => $answer) {
            $no = $number++;
            if ($counter <= 3) break;
            DB::table('detail_visual')->insert([
                'kode' => $kode_test,
                'soal' => 'ujian_seeder/Part1_2/'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_2/'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_2/'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_2/'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_2/'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_2/'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_2/'.$no.'/f.png',
                'jawaban_1' => strtoupper($answer[0]),
                'jawaban_2' => strtoupper($answer[1]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
          
              
           
        }
        $no = 0;
        foreach ($contoh_part1_2 as $key => $value) {
            $no = $key++;
            DB::table('simulasi_ujian_visual')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_2/contoh'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_2/contoh'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_2/contoh'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_2/contoh'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_2/contoh'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_2/contoh'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_2/contoh'.$no.'/f.png',
                'jawaban_1' => strtoupper($value[0]),
                'jawaban_2' => strtoupper($value[1]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::table('simulasi_ujian_visual')->insert([
                'kode' => $kode_test,
                'soal' => 'ujian_seeder/Part1_2/contoh'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_2/contoh'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_2/contoh'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_2/contoh'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_2/contoh'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_2/contoh'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_2/contoh'.$no.'/f.png',
                'jawaban_1' => strtoupper($value[0]),
                'jawaban_2' => strtoupper($value[1]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
