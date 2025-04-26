<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part1_3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part1_3 = [
            1 => "c",
            2 => "a",
            3 => "c",
            4 => "f",
            5 => "b",
            6 => "b",
            7 => "f",
            8 => "a",
            9 => "c",
            10 => "d",
            11 => "d",
            12 => "c",
            13 => "b",
        ];
        $contoh_part1_3 = [
            1 => "b",
            2 => "c",
            3 => "f",
        ];
        $kode = 'part1_3';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 1.3 ',
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
        $tespart1_3 = 'tespart1_3';
        // DB::table('ujian')->insert([
        //     'kode' => $tespart1_3,
        //     'nama' => 'Part 1.3 ',
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
//         DB::table('intruksi_ujians')->insert([
//             'kode' => $tespart1_3,
//             'label' => 'part 1.3.',
//             'urutan' => '1',
//             'intruksi' => 'Pilih satu jawaban yang 
// dianggap paling tepat
// ',
//             'created_at' => Carbon::now(),
//             'updated_at' => Carbon::now()
//         ]);
        DB::table('intruksi_ujians')->insert([
            'kode' => $kode,
            'label' => 'part 1.3.',
            'urutan' => '1',
            'intruksi' => 'Pilih satu jawaban yang 
dianggap paling tepat
',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.png',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'kode_ujian' => $tespart1_3,
            //     'kode_merge_ujian' => 'merge_ujian_2',
            //     'banner' => 'banner2.png',
            //     'instruksi_ujian' => 'Pastikan koneksi stabil.',
            //     'urutan' => 3,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]
        ]);



        foreach ($part1_3 as $number => $answer) {
            $no = $number++;
            DB::table('detail_ujian')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_3/' . $no . '/soal.png',
                'pg_1' => 'ujian_seeder/Part1_3/' . $no . '/a.png',
                'pg_2' => 'ujian_seeder/Part1_3/' . $no . '/b.png',
                'pg_3' => 'ujian_seeder/Part1_3/' . $no . '/c.png',
                'pg_4' => 'ujian_seeder/Part1_3/' . $no . '/d.png',
                'pg_5' => 'ujian_seeder/Part1_3/' . $no . '/e.png',
                'pg_6' => 'ujian_seeder/Part1_3/' . $no . '/f.png',
                'jawaban' => $answer,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $counter = 0;
        $no = 0;
        foreach ($part1_3 as $number => $answer) {
            if ($counter >= 3) break;
            $counter++;
            // DB::table('detail_ujian')->insert([
            //     'kode' => $tespart1_3,
            //     'soal' => 'ujian_seeder/Part1_3/' . $counter . '/soal.png',
            //     'pg_1' => 'ujian_seeder/Part1_3/' . $counter . '/a.png',
            //     'pg_2' => 'ujian_seeder/Part1_3/' . $counter . '/b.png',
            //     'pg_3' => 'ujian_seeder/Part1_3/' . $counter . '/c.png',
            //     'pg_4' => 'ujian_seeder/Part1_3/' . $counter . '/d.png',
            //     'pg_5' => 'ujian_seeder/Part1_3/' . $counter . '/e.png',
            //     'pg_6' => 'ujian_seeder/Part1_3/' . $counter . '/f.png',
            //     'jawaban' => $answer,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ]);
        }
        $no = 0;
        foreach ($contoh_part1_3 as $key => $value) {
            $no = $key++;
            DB::table('simulai_ujan_pg')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part1_3/contoh' . $no . '/soal.png',
                'pg_1' => 'ujian_seeder/Part1_3/contoh' . $no . '/a.png',
                'pg_2' => 'ujian_seeder/Part1_3/contoh' . $no . '/b.png',
                'pg_3' => 'ujian_seeder/Part1_3/contoh' . $no . '/c.png',
                'pg_4' => 'ujian_seeder/Part1_3/contoh' . $no . '/d.png',
                'pg_5' => 'ujian_seeder/Part1_3/contoh' . $no . '/e.png',
                'pg_6' => 'ujian_seeder/Part1_3/contoh' . $no . '/f.png',
                'jawaban' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            // DB::table('simulai_ujan_pg')->insert([
            //     'kode' => $tespart1_3,
            //     'soal' => 'ujian_seeder/Part1_3/contoh' . $no . '/soal.png',
            //     'pg_1' => 'ujian_seeder/Part1_3/contoh' . $no . '/a.png',
            //     'pg_2' => 'ujian_seeder/Part1_3/contoh' . $no . '/b.png',
            //     'pg_3' => 'ujian_seeder/Part1_3/contoh' . $no . '/c.png',
            //     'pg_4' => 'ujian_seeder/Part1_3/contoh' . $no . '/d.png',
            //     'pg_5' => 'ujian_seeder/Part1_3/contoh' . $no . '/e.png',
            //     'pg_6' => 'ujian_seeder/Part1_3/contoh' . $no . '/f.png',
            //     'jawaban' => $value,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ]);
        }
    }
}
