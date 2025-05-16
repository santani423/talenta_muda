<?php

namespace Database\Seeders;

use App\Models\DetailKuisoner;
use App\Models\DetailKuisonerSekala;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part5_3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kuisoner = array(
            array("val0" => "Saya memiliki selera makan baik", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Hampir setiap pagi saya bangun dengan perasaan segar dan siap untuk menghadapi hari tersebut. ", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Kehidupan saya sehari-hari senantiasa menawarkan sesuatu yang menarik bagi diri saya.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya dapat bekerja seperti yang umum saya lakukan. ", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya bekerja dalam situasi yang sangat menekan.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Terkadang saya berpikir tentang hal-hal yang sangat buruk untuk dibicarakan.", "val1" => "L", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya jarang mengalami masalah dengan pencernaan saya.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya merasa  tidak ada seorang pun yang mengerti saya.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Beberapa kali dalam seminggu, perut saya mengalami gangguan.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Terkadang saya merasa sangat frustrasi dan ingin meluapkan kemarahan.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya sulit  untuk tetap fokus pada tugas atau pekerjaan yang sedang saya lakukan.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Ada waktu-waktu ketika saya merasa terhambat dan tidak dapat memulai apa pun selama berhari-hari, berminggu-minggu ataupun berbulan-bulan. ", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => " Saya tidak selalu jujur dalam setiap situasi.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Keputusan saya sekarang cenderung lebih baik daripada keputusan saya sebelumnya.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya tidak membaca setiap daftar topik berita di koran setiap harinya.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Belakangan ini, saya merasa putus asa saat menghadapi beberapa situasi.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sungguh-sungguh merasa kurang yakin dengan diri saya.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sesekali menunda pekerjaan yang seharusnya saya lakukan hari ini hingga besok.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya percaya sebagian besar orang akan mengatakan hal yang tidak benar demi kesuksesan.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sering melakukan hal-hal yang kemudian saya sesali, lebih dari kebanyakan orang lain.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => " Saya tampaknya tidak peduli dengan diri saya sendiri.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saat saya merasa kurang sehat terkadang saya menjadi mudah tersinggung.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya merasa bahagia hampir setiap saat.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Terkadang saya merasa marah.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Cara makan saya lebih baik ketika berada di luar rumah daripada di rumah sendiri.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Banyak orang akan menggunakan cara yang kurang jujur untuk mendapatkan keuntungan, daripada kehilangan kesempatan tersebut.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Jika saya yakin tidak ada yang melihat, saya mungkin akan mencoba masuk ke bioskop tanpa membayar tiket.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Terkadang, saya merasa tidak berguna.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saat masih kecil, saya bergabung dengan sekelompok teman yang berjanji akan saling mendukung dalam segala situasi sulit.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Dalam suatu pertandingan, saya lebih suka meraih kemenangan daripada menelan kekalahan. ", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya tidur tanpa adanya pikiran yang mengganggu hampir setiap malam.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saat ini, saya merasa berada dalam situasi paling balik sepanjang hidup saya.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya tidak mudah lelah.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya ingin menjalin hubungan dengan orang-orang penting, agar saya juga merasa penting.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya tidak menyukai setiap orang yang saya kenal.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Sesekali, saya suka membicarakan orang lain di belakang mereka.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya seringkali merasa murung.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Ada waktu-waktu ketika saya begitu gelisah sehingga sulit bagi saya untuk duduk diam.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya yakin bahwa tingkat kecemasan saya tidak lebih tinggi dari kebanyakan orang.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Terkadang saya memilih kandidat dalam pemilihan yang tidak saya kenal dengan baik.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya kesulitan untuk memulai sesuatu.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Sesekali saya tertawa pada lelucon-lelucon yang tidak sopan.", "val1" => "L", "val2" => "neg", "val3" => "S "),
            array("val0" => "Jika beberapa orang berada dalam kesulitan, saya percaya bahwa penting untuk mencapai kesepakatan dan mendukungnya.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa hidup ini penuh dengan ketegangan hampir setiap saat.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sangat tersentuh oleh beberapa hal bahkan hingga saya tidak dapat membicarakannya.", "val1" => "TRT/TRT2", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya kesulitan untuk fokus pada satu hal saja.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sering kali kehilangan kesabaran dengan orang lain.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa bahwa tidak ada seorang pun yang benar-benar peduli dengan apa yang saya alami.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa memiliki lebih banyak gangguan konsentrasi daripada orang lain.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya cenderung menganggap segala sesuatunya serius.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Terkadang kesulitan-kesulitan saya terasa begitu berat sehingga sulit bagi saya untuk mengatasinya.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sering tidak sadar terhadap gosip dan rumor di lingkungan sosial saya.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa ingin segera menyerah ketika situasi memburuk.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya menghindar untuk menghadapi krisis atau kesulitan.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Ada hal-hal buruk yang saya lakukan di masa lalu yang tidak pernah saya bagikan kepada siapa pun.", "val1" => "TRT/TRT2", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya menjadi gugup jika orang-orang bertanya tentang kehidupan pribadi saya.", "val1" => "TRT/TRT2", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa tidak mampu merencanakan masa depan saya sendiri.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya tidak merasa bahagia dengan keadaan saya saat ini.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa tidak mampu membagikan segala aspek dalam diri saya kepada orang lain.", "val1" => "TRT/TRT2", "val2" => "pos", "val3" => "B "),
            array("val0" => "Masa depan terasa begitu tidak pasti bagi seseorang untuk membuat rencana  serius.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya umumnya tenang dan jarang merasa cemas.", "val1" => "Mt", "val2" => "neg", "val3" => "S "),
            array("val0" => "Terkadang, kekecewaan yang saya rasakan begitu berat sehingga sulit untuk melupakan.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Seringkali saya merasa tidak memiliki kontribusi apa pun.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Beberapa anggota keluarga saya mudah marah.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya hampir selalu merasa kelelahan.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Kadang-kadang saya merasa sedemikian rapuh dan hampir hancur.", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya sangat terganggu oleh kebiasaan lupa saya meletakan benda-benda..", "val1" => "Mt", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya umumnya kesulitan dalam mengambil keputusan terkait apa yang akan saya lakukan.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Menurut saya, penyakit mental adalah tanda kelemahan.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa tidak berdaya ketika harus menghadapi keputusan penting.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Berbicara dengan seseorang tentang masalah saya terasa lebih membantu.", "val1" => "TRT", "val2" => "neg", "val3" => "S "),
            array("val0" => "Tujuan-tujuan hidup utama saya sering kali terasa tercapai.", "val1" => "TRT/TRT1", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya percaya bahwa masalah pribadi seharusnya tetap menjadi rahasia.", "val1" => "TRT/TRT2", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa sangat terganggu dengan pemikiran tentang melakukan perubahan dalam hidup saya.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya tidak suka pergi ke dokter meskipun sakit.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Meskipun tidak bahagia, saya merasa tidak bisa berbuat banyak.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Berbagi perasaan dan pikiran dengan seseorang cenderung lebih efektif daripada mengandalkan obat-obatan.", "val1" => "TRT", "val2" => "neg", "val3" => "S "),
            array("val0" => "Saya menyadari adanya kesalahan dalam diri saya yang sulit untuk diubah.", "val1" => "TRT", "val2" => "pos", "val3" => "B "),
            array("val0" => "Saya merasa sebagian besar masalah saya disebabkan oleh nasib buruk.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Akhir-akhir ini, saya kehilangan motivasi untuk menyelesaikan masalah saya.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B "),
            array("val0" => "Ketika hidup sulit, saya merasa ingin menyerah.", "val1" => "TRT/TRT1", "val2" => "pos", "val3" => "B ")
        );
        $kode = "part5_3";

        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 5.3',
            'jenis' => 2, // Sesuaikan dengan jenis yang berlaku
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
            'nama' => 'Part 5.3',
            'jenis' => 2, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 1, // Waktu default
            'menit' => 30, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $tespart5_3 = "tespart5_3";

        // DB::table('ujian')->insert([
        //     'kode' => $tespart5_3,
        //     'nama' => 'Part 5.3',
        //     'jenis' => 2, // Sesuaikan dengan jenis yang berlaku
        //     'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
        //     'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
        //     'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
        //     'jam' => 1, // Waktu default
        //     'menit' => 30, // Waktu default dalam menit
        //     'acak' => 0,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
        DB::table('intruksi_ujians')->insert([
            'kode' => $kode,
            'label' => 'part 5.3.',
            'urutan' => '1',
            'intruksi' => 'PETUNJUK <br>

Bacalah semua instruksi ini dengan teliti. Persoalan berikut ini terdiri atas 81 pernyataan. Bacalah masing-masing pernyataan dengan hati-hati dan pilihlah satu jawaban benar (B) atau salah (S). <br>

Semua jawaban Anda adalah benar, jadi deskripsikan diri anda secara jujur dan nyatakan pendapat anda seakurat mungkin. Anda harus menjawab semua persoalan yang ada tanpa terlewatkan dan jangan dipikirkan terlalu lama. Waktu yang disediakan 10 menit. <br>  ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        DB::table('intruksi_ujians')->insert([
            'kode' => $tespart5_3,
            'label' => 'part 5.3.',
            'urutan' => '1',
            'intruksi' => 'PETUNJUK <br>

Bacalah semua instruksi ini dengan teliti. Persoalan berikut ini terdiri atas 81 pernyataan. Bacalah masing-masing pernyataan dengan hati-hati dan pilihlah satu jawaban benar (B) atau salah (S). <br>

Semua jawaban Anda adalah benar, jadi deskripsikan diri anda secara jujur dan nyatakan pendapat anda seakurat mungkin. Anda harus menjawab semua persoalan yang ada tanpa terlewatkan dan jangan dipikirkan terlalu lama. Waktu yang disediakan 10 menit. <br>  ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.jpg',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_ujian' => $tespart5_3,
                'kode_merge_ujian' => 'tes_merge_ujian_2',
                'banner' => 'banner2.jpg',
                'instruksi_ujian' => 'Pastikan koneksi stabil.',
                'urutan' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);



        foreach ($kuisoner as $number => $answer) {

            $DetailKuisoner = DetailKuisoner::create([
                'kode' => $kode,  
                'soal' => $answer['val0'], 
                'item' => $answer['val2'],
                'jenis_jawaban_kuesioner_id' => 2, 
                'jawaban' => $answer['val3'], 
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DetailKuisonerSekala::create([
                'detail_kuisoner_id' => $DetailKuisoner->id,
                'kode_sekala' => $answer['val1'], 
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        $counter = 0;
        foreach ($kuisoner as $number => $answer) {
            if ($counter >= 3) break;
            $counter++;
            $DetailKuisoner = DetailKuisoner::create([
                'kode' => $tespart5_3,  
                'soal' => $answer['val0'], 
                'item' => $answer['val2'],
                'jenis_jawaban_kuesioner_id' => 2, 
                'jawaban' => $answer['val3'], 
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DetailKuisonerSekala::create([
                'detail_kuisoner_id' => $DetailKuisoner->id,
                'kode_sekala' => $answer['val1'], 
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
