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
        $part3 =  [
            ["soal" => "Ali memiliki 4 bantal. Ia membeli 6 bantal lagi. Berapa banyak bantal yang ia miliki sekarang?", "jawaban" => 10],
            ["soal" => "Dewi memiliki 13 spidol. Dia memberikan 7 spidol kepada Joni. Berapa banyak spidol yang masih ia miliki sekarang?", "jawaban" => 6],
            ["soal" => "Tono memiliki 4 keponakan dan 20 mainan. Apabila setiap keponakan memperoleh mainan dalam jumlah sama, berapa banyak yang akan diperoleh setiap keponakan Tono?", "jawaban" => 5],
            ["soal" => "Susi berusia 30 tahun. Adam baru berusia 13 tahun. Berapa tahun lebih tuakah Susi dibanding Adam?", "jawaban" => 17],
            ["soal" => "Edi mempunyai 38 buku. Dia menjual separuh bukunya ke toko buku bekas, kemudian ia berniat mendonasikan sebagian buku miliknya yang masih tersisa ke kelompok pecinta buku, Namun sebelum memberikan buku untuk donasi, ia mengambil 4 buku untuk ia simpan sebagai kenangan. Berapakah buku yang akhirnya Edi donasikan ke kelompok pecinta buku?", "jawaban" => 15],
            ["soal" => "Santi memiliki 51 tiket. Dia memberikan tiket pada 7 orang, yang masing-masing mendapat 6 tiket. Berapa tiket yang masih Santi simpan?", "jawaban" => 9],
            ["soal" => "Terdapat 35 coklat dalam setiap kotak. Hasan memiliki 8 kotak berisi coklat, maka ada berapakah coklat yang Hasan miliki?", "jawaban" => 280],
            ["soal" => "Wati memberikan kepada 7 orang masing-masing 6 kartu. Dia memiliki sisa 6 kartu. Berapa banyak kartu yang semula dimiliki Wati?", "jawaban" => 48],
            ["soal" => "Sinta berlari 24 menit setiap Senin sampai Jumat. Dia berlari 55 menit pada hari Sabtu dan Minggu. Berapa menit total dia berlari dalam seminggu?", "jawaban" => 230],
            ["soal" => "Erik mengantri dalam barisan yang terdiri dari 160 orang. Dia membiarkan 20 orang lagi untuk mengantri di depannya. Enam orang mencapai barisan paling depan setiap menitnya. Berapa lama lagi Erik harus berada di antrian sebelum sampai paling depan?", "jawaban" => 3.5],
            ["soal" => "Kamu dapat memang 2 kue dalam 31 menit. Berapa lama yang dibutuhkan untuk memanggang 12 kue?", "jawaban" => 186],
            ["soal" => "Ratna menjual dua pertiga jumlah buku yang dijual Bambang. Ratna menjual 400 buku. Berapa banyak yang dijual oleh Bambang?", "jawaban" => 600],
            ["soal" => "Vania bekerja selama 188 jam dalam 4 minggu . Bila ia bekerja dalam waktu yang sama setiap minggunya, berapa jam ia bekerja setiap minggunya?", "jawaban" => 47],
            ["soal" => "Kris mempunyai es krim 2 kali milik Inge. Kris memiliki 99 es krim. Berapa es krim yang dimiliki oleh Inge?", "jawaban" => 48.5],
            ["soal" => "Pram biasanya berlari 60 putaran mengelilingi lapangan. Dia berlari 15% putaran lebih sedikit hari ini karena kondisi tubuhnya sedang kurang fit. Berapa putaran yang dilakukan Pram hari ini?", "jawaban" => 51],
            ["soal" => "Jika 8 mesin dapat menyelesaikan sebuah pekerjaan dalam 6 hari, berapa mesin yang dibutuhkan untuk menyelesaikan pekerja dalam setengah hari?", "jawaban" => 72],
            ["soal" => "Kantor pos dapat menyortir 20000 surat pada bulan April. Pada bulan Mei, surat yang disortir meningkat 10% . Pada bulan Juni, surat yang disortir meningkat lagi 5 %. Berapa surat yang berhasil disortir pada bulan Juni setelah kedua peningkatan tersebut?", "jawaban" => 23100]
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


        DB::table('intruksi_ujians')->insert([
            'kode' => $kode,
            'label' => 'part 3.',
            'urutan' => '1',
            'intruksi' => 'Jawablah soal-soal berikut ini dengan teliti dan benar!
Tuliskan jawaban Anda pada kolom yang tersedia. Waktu pengerjaan terbatas tapi tidak kami beritahukan batas waktunya. Oleh karena itu kerjakan soal-soal yang Anda anggap paling mudah terlebih dahulu.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        foreach ($part3 as $number => $answer) {
            $detailEssy = DetailEssay::create([
                'kode' => $kode,
                'soal' => $answer['soal'],
                'type_kunci_jawaban' => "number",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            JawabanEssay::create([
                'detail_essay_id' => $detailEssy->id,
                'jawaban' => $answer['jawaban'],
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
                'soal' => $answer['soal'],
                'type_kunci_jawaban' => "number",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            JawabanEssay::create([
                'detail_essay_id' => $detailEssy->id,
                'jawaban' => $answer['jawaban'],
                'nilai' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
