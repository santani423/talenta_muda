<?php

namespace Database\Seeders;

use App\Models\DetailUjian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatePart2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar jawaban part 2
        $part2 = [
            1 => "c",
            2 => "e",
            3 => "a",
            4 => "b",
            5 => "c",
            6 => "d",
            7 => "b",
            8 => "e", // sebelumnya "b"
            9 => "b", // sebelumnya "e"
            10 => "e", // sebelumnya "b"
            11 => "d", // sebelumnya "e"
            12 => "e", // sebelumnya "d"
            13 => "c", // sebelumnya "e"
            14 => "d",
            15 => "a", // sebelumnya "c"
            16 => "b", // sebelumnya "a"
            17 => "d", // sebelumnya "b"
            18 => "c", // sebelumnya "d"
            19 => "c",
            20 => "c",
            21 => "a", // sebelumnya "d"
            22 => "a",
            23 => "a",
            24 => "c", // sebelumnya "a"
            25 => "e",
            26 => "b"
        ];

        $kode = 'part2';
        $data = DetailUjian::where('kode', $kode)->get();

        foreach ($data as $index => $answer) {
            $no = $index + 1;

            DB::table('detail_ujian')->where('id', $answer->id)->update([
                'kode' => $kode,
                'soal' => "ujian_seeder/Part_2/{$no}/soal.png",
                'pg_1' => "ujian_seeder/Part_2/{$no}/a.png",
                'pg_2' => "ujian_seeder/Part_2/{$no}/b.png",
                'pg_3' => "ujian_seeder/Part_2/{$no}/c.png",
                'pg_4' => "ujian_seeder/Part_2/{$no}/d.png",
                'pg_5' => "ujian_seeder/Part_2/{$no}/e.png",
                // 'pg_6' => "ujian_seeder/Part_2/{$no}/f.png", // aktifkan jika perlu
                'jawaban' => $part2[$no] ?? null, // tambahkan null default jika jumlah data tidak sama
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
