<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part1_4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part1_4 = [
            1 => "c",
            2 => "d",
            3 => "b",
            4 => "c",
            5 => "e",
            6 => "a",
            7 => "e",
            8 => "c",
            9 => "b",
            10 => "d"
        ];
        $contoh_part1_4 = [
            1 => "c",
            2 => "d",
            3 => "b", 
        ];
        $kode = 'part1_4';
     DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 1.4',
            'jenis' => 0, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
     DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 1.4',
            'jenis' => 0, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $tespart1_4 = 'tespart1_4';
        // DB::table('ujian')->insert([
        //     'kode' => $tespart1_4,
        //     'nama' => 'Part 1.4',
        //     'jenis' => 0, // Sesuaikan dengan jenis yang berlaku
        //     'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
        //     'kelas_id' => 2, // Sesuaikan dengan ID kelas yang valid
        //     'mapel_id' => 2, // Sesuaikan dengan ID mapel yang valid
        //     'jam' => 1, // Waktu default
        //     'menit' => 30, // Waktu default dalam menit
        //     'acak' => 0,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        DB::table('intruksi_ujians')->insert([
            'kode' => $kode,
            'label' => 'part 1.4.',
            'urutan' => '1',
            'intruksi' => 'Pilih satu jawaban yang 
dianggap paling tepat
',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

//         DB::table('intruksi_ujians')->insert([
//             'kode' => $tespart1_4,
//             'label' => 'part 1.4.',
//             'urutan' => '1',
//             'intruksi' => 'Pilih satu jawaban yang 
// dianggap paling tepat
// ',
//             'created_at' => Carbon::now(),
//             'updated_at' => Carbon::now()
//         ]);
        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.png',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'kode_ujian' => $tespart1_4,
            //     'kode_merge_ujian' => 'tes_merge_ujian_2',
            //     'banner' => 'banner2.png',
            //     'instruksi_ujian' => 'Pastikan koneksi stabil.',
            //     'urutan' => 4,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]
        ]);
        $no = 0;
        foreach ($part1_4 as $number => $answer) { 
            $no = $number++;
            DB::table('detail_ujian')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_4/'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_4/'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_4/'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_4/'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_4/'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_4/'.$no.'/e.png',
                // 'pg_6' => 'ujian_seeder/Part1_4/'.$no.'/f.png',
                'jawaban' => $answer,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
          
        } 

     
        $no = 0;
        $counter = 0;
        foreach ($part1_4 as $number => $answer) { 
            if ($counter >= 3) break;
            $no = $number++;
            // DB::table('detail_ujian')->insert([
            //     'kode' => $tespart1_4,
            //     'soal' => 'ujian_seeder/Part1_4/'.$no.'/soal.png',
            //     'pg_1' => 'ujian_seeder/Part1_4/'.$no.'/a.png',
            //     'pg_2' => 'ujian_seeder/Part1_4/'.$no.'/b.png',
            //     'pg_3' => 'ujian_seeder/Part1_4/'.$no.'/c.png',
            //     'pg_4' => 'ujian_seeder/Part1_4/'.$no.'/d.png',
            //     'pg_5' => 'ujian_seeder/Part1_4/'.$no.'/e.png',
            //     // 'pg_6' => 'ujian_seeder/Part1_4/'.$no.'/f.png',
            //     'jawaban' => $answer,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ]);
            $counter++;
        } 

        $no = 0;
        foreach ($contoh_part1_4 as $number => $answer) { 
            $no = $number++;
            DB::table('simulai_ujan_pg')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_4/contoh'.$no.'/soal.png',
                'pg_1' => 'ujian_seeder/Part1_4/contoh'.$no.'/a.png',
                'pg_2' => 'ujian_seeder/Part1_4/contoh'.$no.'/b.png',
                'pg_3' => 'ujian_seeder/Part1_4/contoh'.$no.'/c.png',
                'pg_4' => 'ujian_seeder/Part1_4/contoh'.$no.'/d.png',
                'pg_5' => 'ujian_seeder/Part1_4/contoh'.$no.'/e.png',
                // 'pg_6' => 'ujian_seeder/Part1_4/contoh'.$no.'/f.png',
                'jawaban' => strtoupper($answer),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]); 
            // DB::table('simulai_ujan_pg')->insert([
            //     'kode' => $tespart1_4,
            //     'soal' => 'ujian_seeder/Part1_4/contoh'.$no.'/soal.png',
            //     'pg_1' => 'ujian_seeder/Part1_4/contoh'.$no.'/a.png',
            //     'pg_2' => 'ujian_seeder/Part1_4/contoh'.$no.'/b.png',
            //     'pg_3' => 'ujian_seeder/Part1_4/contoh'.$no.'/c.png',
            //     'pg_4' => 'ujian_seeder/Part1_4/contoh'.$no.'/d.png',
            //     'pg_5' => 'ujian_seeder/Part1_4/contoh'.$no.'/e.png',
            //     // 'pg_6' => 'ujian_seeder/Part1_4/contoh'.$no.'/f.png',
            //     'jawaban' => strtoupper($answer),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ]); 
        }
     
 
        
    }
}
