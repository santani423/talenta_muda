<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part2 = [
            1 => "c",
            2 => "c",
            3 => "e",
            4 => "a",
            5 => "b",
            6 => "c",
            7 => "d",
            8 => "b",
            9 => "e",
            10 => "b",
            11 => "e",
            12 => "d",
            13 => "e",
            14 => "d",
            15 => "c",
            16 => "a",
            17 => "b",
            18 => "d",
            19 => "c",
            20 => "c",
            21 => "d",
            22 => "a",
            23 => "a",
            24 => "a",
            25 => "e",
            26 => "b"
        ];
        $contoh_part2 = [
            1 => "a",
            2 => "c",
        ];
        $kode = 'part2';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 2',
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

        $tespart2 = 'tespart2';
        DB::table('ujian')->insert([
            'kode' => $tespart2,
            'nama' => 'Part 2',
            'jenis' => 0, // Sesuaikan dengan jenis yang berlaku
            'guru_id' =>  2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 2, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 2, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.png',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_ujian' => $tespart2,
                'kode_merge_ujian' => 'tes_merge_ujian_2',
                'banner' => 'banner2.png',
                'instruksi_ujian' => 'Pastikan koneksi stabil.',
                'urutan' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        foreach ($part2 as $number => $answer) {
            $no = $number++;
            DB::table('detail_ujian')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part_2/' . $no . '/soal.png',
                'pg_1' => 'ujian_seeder/Part_2/' . $no . '/a.png',
                'pg_2' => 'ujian_seeder/Part_2/' . $no . '/b.png',
                'pg_3' => 'ujian_seeder/Part_2/' . $no . '/c.png',
                'pg_4' => 'ujian_seeder/Part_2/' . $no . '/d.png',
                'pg_5' => 'ujian_seeder/Part_2/' . $no . '/e.png',
                // 'pg_6' => 'ujian_seeder/Part_2/' . $no . '/f.png',
                'jawaban' => $answer,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $no = 0;
        foreach ($contoh_part2 as $number => $answer) {
            $no = $number++;
            DB::table('simulai_ujan_pg')->insert([
                'kode' => $kode,
                'soal' => 'ujian_seeder/Part_2/contoh' . $no . '/soal.png',
                'pg_1' => 'ujian_seeder/Part_2/contoh' . $no . '/a.png',
                'pg_2' => 'ujian_seeder/Part_2/contoh' . $no . '/b.png',
                'pg_3' => 'ujian_seeder/Part_2/contoh' . $no . '/c.png',
                'pg_4' => 'ujian_seeder/Part_2/contoh' . $no . '/d.png',
                'pg_5' => 'ujian_seeder/Part_2/contoh' . $no . '/e.png',
                // 'pg_6' => 'ujian_seeder/Part_2/contoh' . $no . '/f.png',
                'jawaban' => strtoupper($answer),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::table('simulai_ujan_pg')->insert([
                'kode' => $tespart2,
                'soal' => 'ujian_seeder/Part_2/contoh' . $no . '/soal.png',
                'pg_1' => 'ujian_seeder/Part_2/contoh' . $no . '/a.png',
                'pg_2' => 'ujian_seeder/Part_2/contoh' . $no . '/b.png',
                'pg_3' => 'ujian_seeder/Part_2/contoh' . $no . '/c.png',
                'pg_4' => 'ujian_seeder/Part_2/contoh' . $no . '/d.png',
                'pg_5' => 'ujian_seeder/Part_2/contoh' . $no . '/e.png',
                // 'pg_6' => 'ujian_seeder/Part_2/contoh' . $no . '/f.png',
                'jawaban' => strtoupper($answer),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
 
        $no = 0;
        foreach ($part2 as $number => $answer) {
            if ($number >= 3) break;
            $no = $number++;
            DB::table('detail_ujian')->insert([
                'kode' => $tespart2,
                'soal' => 'ujian_seeder/Part_2/' . $no . '/soal.png',
                'pg_1' => 'ujian_seeder/Part_2/' . $no . '/a.png',
                'pg_2' => 'ujian_seeder/Part_2/' . $no . '/b.png',
                'pg_3' => 'ujian_seeder/Part_2/' . $no . '/c.png',
                'pg_4' => 'ujian_seeder/Part_2/' . $no . '/d.png',
                'pg_5' => 'ujian_seeder/Part_2/' . $no . '/e.png',
                // 'pg_6' => 'ujian_seeder/Part_2/' . $no . '/f.png',
                'jawaban' => $answer,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
