<?php

namespace Database\Seeders;

use App\Models\DetailEssay;
use App\Models\JawabanEssay;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $soal = [
            1 => [
                "skor_2" => ["Alat untuk makan", "peralatan makan", "perkakas makan"],
                "skor_1" => ["Makan", "sesuatu di meja", "sesuatu yang dapat dipegang"],
                "skor_0" => ["Terbuat dari plastik", "logam", "perak"]
            ],
            2 => [
                "skor_2" => ["Warna", "warna warni"],
                "skor_1" => ["Corak", "ada dalam lampu", "cat", "krayon", "spidol"],
                "skor_0" => ["Sayuran", "makanan"]
            ],
            3 => [
                "skor_2" => ["Sayuran", "sayur mayur"],
                "skor_1" => ["Hasil bumi", "makanan", "tanaman"],
                "skor_0" => []
            ],
            4 => [
                "skor_2" => ["Binatang", "Binatang kaki empat", "makhluk hidup"],
                "skor_1" => ["Sama-sama kaki empat", "sama-sama kuat"],
                "skor_0" => ["Hidup di alam bebas", "sama-sama punya ekor"]
            ],
            5 => [
                "skor_2" => ["Alat musik"],
                "skor_1" => ["Keduanya menghasilkan suara", "bisa berbunyi"],
                "skor_0" => ["Memiliki ritme"]
            ],
            6 => [
                "skor_2" => ["Alat transportasi", "kendaraan"],
                "skor_1" => ["Sama-sama bergerak", "sama-sama dikendarai"],
                "skor_0" => ["Keduanya dijalankan mesin", "keduanya butuh bensin"]
            ],
            7 => [
                "skor_2" => ["Alat Indera", "sensori"],
                "skor_1" => ["Organ tubuh", "bagian tubuh"],
                "skor_0" => ["Membantu untuk melihat dan mendengar"]
            ],
            8 => [
                "skor_2" => ["Sumber energi", "sumber bahan bakar", "sumber daya"],
                "skor_1" => ["Kebutuhan", "dapat terus bergerak"],
                "skor_0" => ["Untuk perjalanan", "dibutuhkan setiap hari"]
            ],
            9 => [
                "skor_2" => ["Simbol", "emblem"],
                "skor_1" => ["Hiasan", "penghargaan"],
                "skor_0" => ["Sesuatu yang digunakan", "symbol Kerajaan", "simbol Kerajaan"]
            ],
            10 => [
                "skor_2" => ["Awal kehidupan", "tahap awal perkembangan kehidupan"],
                "skor_1" => ["Keturunan", "sesuatu yang baru"],
                "skor_0" => ["Kecil", "butuh perawatan"]
            ],
            11 => [
                "skor_2" => ["Memiliki ritme", "sama-sama gelombang"],
                "skor_1" => ["Mengikuti pola", "bunyi gelombang"],
                "skor_0" => ["Memiliki melodi", "artistik"]
            ],
            12 => [
                "skor_2" => ["Karya seni", "ciptaan artistik"],
                "skor_1" => ["Ciptaan manusia", "menggambarkan sesuatu"],
                "skor_0" => ["Benda mati"]
            ],
            13 => [
                "skor_2" => ["Menahan benda tetap pada tempatnya", "membatasi gerakan"],
                "skor_1" => ["Menghentikan sesuatu"],
                "skor_0" => ["Benda tidak bergerak", "benda dari logam", "benda dari kayu"]
            ],
            14 => [
                "skor_2" => ["Perkiraan masa depan", "sesuatu yang belum terjadi"],
                "skor_1" => ["Bentuk pemikiran", "mimpi"],
                "skor_0" => ["Hasil"]
            ],
            15 => [
                "skor_2" => ["Respon terhadap sesuatu", "reaksi terhadap sesuatu", "konsekuensi", "hasil"],
                "skor_1" => ["Perasaan", "perilaku orang", "pendapat"],
                "skor_0" => ["Pengalaman"]
            ],
            16 => [
                "skor_2" => ["Tidak terbatas", "titik absolut"],
                "skor_1" => ["Sesuatu yang abadi", "menyangkut waktu", "menyangkut persepsi"],
                "skor_0" => ["Pilihan yang dibuat seseorang"]
            ],
            17 => [
                "skor_2" => ["Titik ekstrim dalam suatu hubungan"],
                "skor_1" => ["Cara menilai seseorang", "klasifikasi terhadap seseorang"],
                "skor_0" => ["Perasaan", "setiap orang memilikinya"]
            ],
            18 => [
                "skor_2" => ["Ekspresi perasaan pada dua kutub berbeda"],
                "skor_1" => ["Perasaan"],
                "skor_0" => ["Hubungan dengan orang lain"]
            ]
        ];

        $kode = 'part4';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 4',
            'jenis' => 1, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'nilai_tambahan' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $tespart4 = 'tespart4';
        DB::table('ujian')->insert([
            'kode' => $tespart4,
            'nama' => 'Part 4',
            'jenis' => 1, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'nilai_tambahan' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        
        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.jpg',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_ujian' => $tespart4,
                'kode_merge_ujian' => 'tes_merge_ujian_2',
                'banner' => 'banner2.jpg',
                'instruksi_ujian' => 'Pastikan koneksi stabil.',
                'urutan' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        foreach ($soal as $number => $answer) {

          


            $detailEssy = DetailEssay::create([
                'kode' => $kode,
                'soal' => 'Soal ' . $number, 
                'type_kunci_jawaban' => "text",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            foreach ($answer['skor_0'] as $jawab) {
                JawabanEssay::create([
                    'detail_essay_id' => $detailEssy->id,
                    'jawaban' => $jawab,
                    'nilai' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            foreach ($answer['skor_1'] as $jawab) {
                JawabanEssay::create([
                    'detail_essay_id' => $detailEssy->id,
                    'jawaban' => $jawab,
                    'nilai' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            foreach ($answer['skor_2'] as $jawab) {
                JawabanEssay::create([
                    'detail_essay_id' => $detailEssy->id,
                    'jawaban' => $jawab,
                    'nilai' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
             
        }
        $counter = 0;
        foreach ($soal as $number => $answer) {

            if ($counter >= 3) break;
            $counter++;


            $detailEssy = DetailEssay::create([
                'kode' => $tespart4,
                'soal' => 'Soal ' . $number, 
                'type_kunci_jawaban' => "text",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            foreach ($answer['skor_0'] as $jawab) {
                JawabanEssay::create([
                    'detail_essay_id' => $detailEssy->id,
                    'jawaban' => $jawab,
                    'nilai' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            foreach ($answer['skor_1'] as $jawab) {
                JawabanEssay::create([
                    'detail_essay_id' => $detailEssy->id,
                    'jawaban' => $jawab,
                    'nilai' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            foreach ($answer['skor_2'] as $jawab) {
                JawabanEssay::create([
                    'detail_essay_id' => $detailEssy->id,
                    'jawaban' => $jawab,
                    'nilai' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
             
        }
        
    }
}
