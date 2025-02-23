<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Part1_1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part1_1 = [
            1 => "b",
            2 => "d",
            3 => "c",
            4 => "a",
            5 => "c",
            6 => "b",
            7 => "e",
            8 => "b",
            9 => "c",
            10 => "c",
            11 => "d",
            12 => "f",
            13 => "e"
        ];
        $contoh_part1_1 = [
            1 => "f",
            2 => "a",
            3 => "e"
        ];
        $kode = 'part1_1';
        $kode_test = 'tes_part1_1';
        
        DB::table('ujian')->insert([
            'kode' => $kode_test,
            'nama' => 'Part 1.1 ',
            'jenis' => 0, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 2, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 2, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 1.1 ',
            'jenis' => 0, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
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
                'urutan' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_ujian' => $kode_test,
                'kode_merge_ujian' => 'tes_merge_ujian_2',
                'banner' => 'banner2.png',
                'instruksi_ujian' => 'Pastikan koneksi stabil.',
                'urutan' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        foreach ($part1_1 as $number => $answer) { 
            $no = $number++;
            DB::table('detail_ujian')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_1/'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_1/'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_1/'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_1/'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_1/'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_1/'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_1/'.$no.'/f.png',
                'jawaban' => strtoupper($answer),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]); 
        }
        
        $no = 0;

        foreach ($contoh_part1_1 as $number => $answer) { 
            $no = $number++;
            DB::table('simulai_ujan_pg')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_1/contoh'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_1/contoh'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_1/contoh'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_1/contoh'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_1/contoh'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_1/contoh'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_1/contoh'.$no.'/f.png',
                'jawaban' => strtoupper($answer),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]); 
            DB::table('simulai_ujan_pg')->insert([
                'kode' => $kode_test,
                'soal' => 'ujian_seeder/Part1_1/contoh'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_1/contoh'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_1/contoh'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_1/contoh'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_1/contoh'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_1/contoh'.$no.'/e.png',
                'pg_6' => 'ujian_seeder/Part1_1/contoh'.$no.'/f.png',
                'jawaban' => strtoupper($answer),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]); 
        }

        $counter = 0;
        $no = 0;
        foreach ($part1_1 as $number => $answer) { 
            if ($counter >= 3) break;
            $counter++; 
            $no = $number++;
            DB::table('detail_ujian')->insert([
            'kode' => $kode_test,
            'soal' => 'ujian_seeder/Part1_1/'.$no.'/soal.png',
            'pg_1' => 'ujian_seeder/Part1_1/'.$no.'/a.png',
            'pg_2' => 'ujian_seeder/Part1_1/'.$no.'/b.png',
            'pg_3' => 'ujian_seeder/Part1_1/'.$no.'/c.png',
            'pg_4' => 'ujian_seeder/Part1_1/'.$no.'/d.png',
            'pg_5' => 'ujian_seeder/Part1_1/'.$no.'/e.png',
            'pg_6' => 'ujian_seeder/Part1_1/'.$no.'/f.png',
            'jawaban' => strtoupper($answer),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ]);

            
            

        }
    }
}
