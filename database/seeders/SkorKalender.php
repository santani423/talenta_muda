<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkorKalender extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = array(
            array("val0" => "49", "val1" => "-", "val2" => "-", "val3" => "-", "val4" => "-", "val5" => "183", "val6" => "183"),
            array("val0" => "48", "val1" => "-", "val2" => "-", "val3" => "183", "val4" => "181", "val5" => "179", "val6" => "179"),
            array("val0" => "47", "val1" => "-", "val2" => "183", "val3" => "179", "val4" => "178", "val5" => "176", "val6" => "176"),
            array("val0" => "46", "val1" => "183", "val2" => "179", "val3" => "176", "val4" => "175", "val5" => "173", "val6" => "173"),
            array("val0" => "45", "val1" => "179", "val2" => "176", "val3" => "173", "val4" => "171", "val5" => "169", "val6" => "169"),
            array("val0" => "-", "val1" => "178", "val2" => "175", "val3" => "171", "val4" => "169", "val5" => "168", "val6" => "168"),
            array("val0" => "44", "val1" => "176", "val2" => "173", "val3" => "169", "val4" => "168", "val5" => "167", "val6" => "167"),
            array("val0" => "43", "val1" => "175", "val2" => "171", "val3" => "168", "val4" => "167", "val5" => "165", "val6" => "165"),
            array("val0" => "-", "val1" => "173", "val2" => "170", "val3" => "167", "val4" => "165", "val5" => "163", "val6" => "163"),
            array("val0" => "42", "val1" => "171", "val2" => "168", "val3" => "165", "val4" => "163", "val5" => "161", "val6" => "161"),
            array("val0" => "-", "val1" => "170", "val2" => "167", "val3" => "163", "val4" => "161", "val5" => "160", "val6" => "160"),
            array("val0" => "-", "val1" => "168", "val2" => "165", "val3" => "161", "val4" => "160", "val5" => "159", "val6" => "159"),
            array("val0" => "41", "val1" => "167", "val2" => "163", "val3" => "160", "val4" => "159", "val5" => "157", "val6" => "157"),
            array("val0" => "40", "val1" => "165", "val2" => "161", "val3" => "159", "val4" => "157", "val5" => "155", "val6" => "155"),
            array("val0" => "-", "val1" => "163", "val2" => "160", "val3" => "157", "val4" => "155", "val5" => "154", "val6" => "154"),
            array("val0" => "39", "val1" => "161", "val2" => "159", "val3" => "155", "val4" => "154", "val5" => "152", "val6" => "152"),
            array("val0" => "-", "val1" => "160", "val2" => "157", "val3" => "154", "val4" => "152", "val5" => "150", "val6" => "150"),
            array("val0" => "38", "val1" => "159", "val2" => "155", "val3" => "152", "val4" => "150", "val5" => "149", "val6" => "149"),
            array("val0" => "-", "val1" => "157", "val2" => "154", "val3" => "150", "val4" => "149", "val5" => "147", "val6" => "147"),
            array("val0" => "37", "val1" => "155", "val2" => "152", "val3" => "149", "val4" => "147", "val5" => "145", "val6" => "145"),
            array("val0" => "-", "val1" => "154", "val2" => "150", "val3" => "147", "val4" => "145", "val5" => "144", "val6" => "144"),
            array("val0" => "36", "val1" => "152", "val2" => "149", "val3" => "145", "val4" => "144", "val5" => "142", "val6" => "142"),
            array("val0" => "35", "val1" => "150", "val2" => "147", "val3" => "144", "val4" => "142", "val5" => "140", "val6" => "140"),
            array("val0" => "-", "val1" => "149", "val2" => "145", "val3" => "142", "val4" => "140", "val5" => "139", "val6" => "139"),
            array("val0" => "34", "val1" => "147", "val2" => "144", "val3" => "140", "val4" => "139", "val5" => "137", "val6" => "137"),
            array("val0" => "-", "val1" => "145", "val2" => "142", "val3" => "139", "val4" => "137", "val5" => "136", "val6" => "136"),
            array("val0" => "-", "val1" => "144", "val2" => "140", "val3" => "137", "val4" => "136", "val5" => "134", "val6" => "134"),
            array("val0" => "33", "val1" => "142", "val2" => "139", "val3" => "136", "val4" => "134", "val5" => "133", "val6" => "133"),
            array("val0" => "32", "val1" => "140", "val2" => "137", "val3" => "134", "val4" => "133", "val5" => "131", "val6" => "131"),
            array("val0" => "-", "val1" => "139", "val2" => "136", "val3" => "133", "val4" => "131", "val5" => "129", "val6" => "129"),
            array("val0" => "31", "val1" => "137", "val2" => "134", "val3" => "131", "val4" => "129", "val5" => "128", "val6" => "128"),
            array("val0" => "-", "val1" => "136", "val2" => "133", "val3" => "129", "val4" => "128", "val5" => "126", "val6" => "126"),
            array("val0" => "30", "val1" => "134", "val2" => "131", "val3" => "128", "val4" => "126", "val5" => "124", "val6" => "124"),
            array("val0" => "-", "val1" => "133", "val2" => "129", "val3" => "126", "val4" => "124", "val5" => "123", "val6" => "123"),
            array("val0" => "29", "val1" => "131", "val2" => "128", "val3" => "124", "val4" => "123", "val5" => "121", "val6" => "121"),
            array("val0" => "28", "val1" => "129", "val2" => "126", "val3" => "123", "val4" => "121", "val5" => "119", "val6" => "119"),
            array("val0" => "27", "val1" => "126", "val2" => "123", "val3" => "119", "val4" => "117", "val5" => "116", "val6" => "116"),
            array("val0" => "-", "val1" => "124", "val2" => "121", "val3" => "117", "val4" => "116", "val5" => "114", "val6" => "114"),
            array("val0" => "26", "val1" => "123", "val2" => "119", "val3" => "116", "val4" => "114", "val5" => "113", "val6" => "113"),
            array("val0" => "-", "val1" => "121", "val2" => "117", "val3" => "114", "val4" => "113", "val5" => "111", "val6" => "111"),
            array("val0" => "25", "val1" => "119", "val2" => "116", "val3" => "113", "val4" => "111", "val5" => "109", "val6" => "109"),
            array("val0" => "-", "val1" => "117", "val2" => "114", "val3" => "111", "val4" => "109", "val5" => "108", "val6" => "108"),
            array("val0" => "24", "val1" => "116", "val2" => "113", "val3" => "109", "val4" => "108", "val5" => "106", "val6" => "106"),
            array("val0" => "-", "val1" => "114", "val2" => "111", "val3" => "108", "val4" => "106", "val5" => "104", "val6" => "104"),
            array("val0" => "23", "val1" => "113", "val2" => "109", "val3" => "106", "val4" => "104", "val5" => "103", "val6" => "103"),
            array("val0" => "-", "val1" => "111", "val2" => "108", "val3" => "104", "val4" => "103", "val5" => "101", "val6" => "101"),
            array("val0" => "22", "val1" => "109", "val2" => "106", "val3" => "103", "val4" => "101", "val5" => "100", "val6" => "100"),
            array("val0" => "-", "val1" => "108", "val2" => "104", "val3" => "101", "val4" => "100", "val5" => "98", "val6" => "98"),
            array("val0" => "21", "val1" => "106", "val2" => "103", "val3" => "100", "val4" => "98", "val5" => "96", "val6" => "96"),
            array("val0" => "20", "val1" => "104", "val2" => "101", "val3" => "98", "val4" => "96", "val5" => "94", "val6" => "94"),
            array("val0" => "-", "val1" => "103", "val2" => "100", "val3" => "96", "val4" => "94", "val5" => "93", "val6" => "93"),
            array("val0" => "19", "val1" => "101", "val2" => "98", "val3" => "94", "val4" => "93", "val5" => "91", "val6" => "91"),
            array("val0" => "-", "val1" => "100", "val2" => "96", "val3" => "93", "val4" => "91", "val5" => "89", "val6" => "89"),
            array("val0" => "18", "val1" => "98", "val2" => "94", "val3" => "91", "val4" => "89", "val5" => "88", "val6" => "88"),
            array("val0" => "-", "val1" => "96", "val2" => "93", "val3" => "89", "val4" => "88", "val5" => "86", "val6" => "86"),
            array("val0" => "17", "val1" => "94", "val2" => "91", "val3" => "88", "val4" => "86", "val5" => "85", "val6" => "85"),
            array("val0" => "-", "val1" => "93", "val2" => "89", "val3" => "86", "val4" => "85", "val5" => "83", "val6" => "83"),
            array("val0" => "16", "val1" => "91", "val2" => "88", "val3" => "85", "val4" => "83", "val5" => "81", "val6" => "81"),
            array("val0" => "-", "val1" => "89", "val2" => "86", "val3" => "83", "val4" => "81", "val5" => "80", "val6" => "80"),
            array("val0" => "15", "val1" => "88", "val2" => "85", "val3" => "81", "val4" => "80", "val5" => "78", "val6" => "78"),
            array("val0" => "-", "val1" => "86", "val2" => "83", "val3" => "80", "val4" => "78", "val5" => "76", "val6" => "76"),
            array("val0" => "14", "val1" => "85", "val2" => "81", "val3" => "78", "val4" => "76", "val5" => "75", "val6" => "75"),
            array("val0" => "-", "val1" => "83", "val2" => "80", "val3" => "76", "val4" => "75", "val5" => "73", "val6" => "73"),
            array("val0" => "13", "val1" => "81", "val2" => "78", "val3" => "75", "val4" => "73", "val5" => "72", "val6" => "72"),
            array("val0" => "12", "val1" => "80", "val2" => "76", "val3" => "73", "val4" => "72", "val5" => "70", "val6" => "70"),
            array("val0" => "-", "val1" => "78", "val2" => "75", "val3" => "72", "val4" => "70", "val5" => "68", "val6" => "68"),
            array("val0" => "11", "val1" => "76", "val2" => "73", "val3" => "70", "val4" => "68", "val5" => "67", "val6" => "67"),
            array("val0" => "-", "val1" => "75", "val2" => "72", "val3" => "68", "val4" => "67", "val5" => "65", "val6" => "65"),
            array("val0" => "10", "val1" => "73", "val2" => "70", "val3" => "67", "val4" => "65", "val5" => "63", "val6" => "63"),
            array("val0" => "-", "val1" => "72", "val2" => "68", "val3" => "65", "val4" => "63", "val5" => "62", "val6" => "62"),
            array("val0" => "9", "val1" => "70", "val2" => "67", "val3" => "63", "val4" => "62", "val5" => "60", "val6" => "60"),
            array("val0" => "-", "val1" => "68", "val2" => "65", "val3" => "62", "val4" => "60", "val5" => "58", "val6" => "58"),
            array("val0" => "8", "val1" => "67", "val2" => "63", "val3" => "60", "val4" => "58", "val5" => "57", "val6" => "57"),
            array("val0" => "-", "val1" => "65", "val2" => "62", "val3" => "58", "val4" => "57", "val5" => "56", "val6" => "56"),
            array("val0" => "7", "val1" => "63", "val2" => "60", "val3" => "57", "val4" => "56", "val5" => "55", "val6" => "55"),
            array("val0" => "-", "val1" => "62", "val2" => "58", "val3" => "56", "val4" => "55", "val5" => "53", "val6" => "53"),
            array("val0" => "6", "val1" => "60", "val2" => "57", "val3" => "55", "val4" => "53", "val5" => "52", "val6" => "52"),
            array("val0" => "-", "val1" => "58", "val2" => "56", "val3" => "54", "val4" => "52", "val5" => "50", "val6" => "50"),
            array("val0" => "5", "val1" => "57", "val2" => "55", "val3" => "53", "val4" => "51", "val5" => "48", "val6" => "48"),
            array("val0" => "4", "val1" => "55", "val2" => "54", "val3" => "51", "val4" => "50", "val5" => "47", "val6" => "47"),
            array("val0" => "-", "val1" => "54", "val2" => "53", "val3" => "50", "val4" => "48", "val5" => "46", "val6" => "46"),
            array("val0" => "3", "val1" => "53", "val2" => "52", "val3" => "48", "val4" => "47", "val5" => "45", "val6" => "45"),
            array("val0" => "2", "val1" => "52", "val2" => "51", "val3" => "47", "val4" => "46", "val5" => "43", "val6" => "43"),
            array("val0" => "1", "val1" => "50", "val2" => "50", "val3" => "46", "val4" => "45", "val5" => "40", "val6" => "40"),
            array("val0" => "0", "val1" => "48", "val2" => "48", "val3" => "45", "val4" => "43", "val5" => "38", "val6" => "38"),
        );

        foreach ($array as $key => $value) {
            DB::table('skor_kalenders')->insert([
                'total_raw_score' => $value['val0'],
                'usia_dari_tahun' => '13',
                'usia_dari_bulan' => '0',
                'usia_sampai_tahun' => '13',
                'usia_sampai_bulan' => '4',
                'nilai' => $value['val1'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('skor_kalenders')->insert([
                'total_raw_score' => $value['val0'],
                'usia_dari_tahun' => '13',
                'usia_dari_bulan' => '5',
                'usia_sampai_tahun' => '13',
                'usia_sampai_bulan' => '11',
                'nilai' => $value['val2'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('skor_kalenders')->insert([
                'total_raw_score' => $value['val0'],
                'usia_dari_tahun' => '14',
                'usia_dari_bulan' => '0',
                'usia_sampai_tahun' => '14',
                'usia_sampai_bulan' => '11',
                'nilai' => $value['val3'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('skor_kalenders')->insert([
                'total_raw_score' => $value['val0'],
                'usia_dari_tahun' => '15',
                'usia_dari_bulan' => '0',
                'usia_sampai_tahun' => '15',
                'usia_sampai_bulan' => '11',
                'nilai' => $value['val4'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('skor_kalenders')->insert([
                'total_raw_score' => $value['val0'],
                'usia_dari_tahun' => '16',
                'usia_dari_bulan' => '0',
                'usia_sampai_tahun' => '16',
                'usia_sampai_bulan' => '11',
                'nilai' => $value['val5'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('skor_kalenders')->insert([
                'total_raw_score' => $value['val0'],
                'usia_dari_tahun' => '17',
                'usia_dari_bulan' => '0',
                'usia_sampai_tahun' => '0',
                'usia_sampai_bulan' => '0',
                'nilai' => $value['val6'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
