<?php

namespace Database\Seeders;

use App\Models\DetailKuisoner;
use App\Models\DetailKuisonerSekala;
use App\Models\Sekala;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part5_2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kuisoner = array(
            array("val0" => "Sulit bagi saya untuk melihat seseorang yang sedang menderita", "val1" => "Crudelia", "val2" => "positif"),
            array("val0" => "Dalam segala hal, lebih baik menjadi orang yang rendah hati dan jujur daripada menjadi orang yang memiliki kedudukan tinggi dan tidak jujur", "val1" => "Egoism", "val2" => "positif"),
            array("val0" => "Orang yang cerdas selalu tahu kapan, bagaimana, dan kepada siapa ia harus berkata-kata untuk menentukan nasib orang yang menyinggung dia", "val1" => "Frustalia", "val2" => "negatif"),
            array("val0" => "Kebanyakan orang pada dasarnya baik dan murah hati", "val1" => "Machiavellianism", "val2" => "positif"),
            array("val0" => "Saya tidak keberatan untuk berbagi panggung dengan orang lain", "val1" => "Narcissism", "val2" => "positif"),
            array("val0" => "Pembalasan harus cepat dan kejam", "val1" => "Psychopathy", "val2" => "negatif"),
            array("val0" => "Jika saya berada di Titanic, maka saya tidak memiliki lebih banyak hak dibandingkan penumpang lain untuk berada di sekoci penyelamat pertama", "val1" => "Psychological Entitlement", "val2" => "negatif"),
            array("val0" => "Jika saya merasa terganggu, mempersulit kehidupan orang lain akan membuat saya merasa lebih baik", "val1" => "Sadism", "val2" => "positif"),
            array("val0" => "Tidak baik untuk menyebar rumor, sekalipun itu dilakukan untuk membela orang-orang yang dekat dengan kita", "val1" => "Moral Disengagement", "val2" => "positif"),
            array("val0" => "Jika tetangga saya mengeluh mengenai terlalu kerasnya musik yang saya mainkan, maka saya akan mengecilkan suaranya, walaupun saya merasa terganggu oleh keluhannya", "val1" => "Spitefulness", "val2" => "negatif"),
            array("val0" => "Yang saya pikirkan hanyalah kesenangan pribadi", "val1" => "Crudelia", "val2" => "positif"),
            array("val0" => "Jika jalan pintas menuju kesuksesan dengan melanggar hukum, tentu bukan langkah tepat untuk mengambilnya", "val1" => "Frustalia", "val2" => "negatif"),
            array("val0" => "Tidak peduli seberapa banyak yang telah saya miliki, saya selalu ingin lebih lagi", "val1" => "Greed", "val2" => "positif"),
            array("val0" => "Saya percaya bahwa berbohong itu diperlukan untuk mempertahankan keunggulan kompetitif atas orang lain", "val1" => "Machiavellianism", "val2" => "positif"),
            array("val0" => "Pada prinsipnya setiap orang berhak diperlakukan sama", "val1" => "Narcissism", "val2" => "positif"),
            array("val0" => "Saya akan mengatakan apapun untuk mendapatkan apa yang saya inginkan", "val1" => "Psychopathy", "val2" => "negatif"),
            array("val0" => "Menyakiti orang akan membuat saya merasa sangat tidak nyaman", "val1" => "Sadism", "val2" => "positif"),
            array("val0" => "Jika saya memiliki kesempatan, saya dengan senang hati mau membayar sejumlah kecil uang untuk melihat teman sekelas yang tidak saya sukai gagal dalam ujian akhir", "val1" => "Spitefulness", "val2" => "positif"),
            array("val0" => "Berbuat baik tidak memiliki keuntungan apapun, hal itu hanya akan membuat orang miskin dan malas", "val1" => "Crudelia", "val2" => "positif"),
            array("val0" => "Jangan pernah memberitahu siapapun alasan sebenarnya kamu melakukan sesuatu, kecuali hal tersebut berguna untuk dilakukan", "val1" => "Egoism", "val2" => "negatif"),

            array("val0" => "Seseorang harus menggunakan segala cara yang dapat menguntungkannya, tetapi jangan sampai diketahui oleh orang lain", "val1" => "Frustalia", "val2" => "positif"),
            array("val0" => "Sebetulnya, saya agak serakah", "val1" => "Greed", "val2" => "positif"),
            array("val0" => "Saya tidak terlalu peduli untuk memiliki kontrol atas orang lain.", "val1" => "Machiavellianism", "val2" => "positif"),
            array("val0" => "Orang yang mencari masalah dengan saya selalu menyesalinya.", "val1" => "Psychopathy", "val2" => "negatif"),
            array("val0" => "Banyak hal tidak dapat berjalan sesuai dengan keinginan saya", "val1" => "Psychological Entitlement", "val2" => "positif"),
            array("val0" => "Saya berpikir tentang melecehkan orang lain untuk kesenangan.", "val1" => "Sadism", "val2" => "positif"),
            array("val0" => "Saya pantang mencuri ide orang lain untuk mendapatkan pengakuan", "val1" => "Moral Disengagement", "val2" => "negatif"),
            array("val0" => "Saya tidak terlalu bersimpati terhadap orang lain atau masalah-masalah mereka", "val1" => "Self Centeredness", "val2" => "positif"),
            array("val0" => "Ada saatnya saya rela menderita agar saya bisa menghukum orang lain yang layak dihukum", "val1" => "Spitefulness", "val2" => "positif"),
            array("val0" => "Kenapa saya harus peduli dengan orang lain, ketika tidak ada orang yang peduli dengan saya?", "val1" => "Crudelia", "val2" => "negatif"),
            array("val0" => "Saya tidak akan berbuat curang walaupun hanya terdapat sedikit kemungkinan untuk tertangkap", "val1" => "Machiavellianism", "val2" => "positif"),
            array("val0" => "Sebagian besar orang, entah bagaimana, adalah orang-orang yang gagal", "val1" => "Narcissism", "val2" => "positif"),
            array("val0" => "Saya tidak terlalu suka untuk memanipulasi perasaan orang lain", "val1" => "Psychopathy", "val2" => "positif"),
            array("val0" => "Saya tidak bisa membayangkan bagaimana bertindak jahat terhadap orang lain bisa begitu menyenangkan", "val1" => "Sadism", "val2" => "positif"),
            array("val0" => "Saya mau menjadi sukarelawan untuk orang yang membutuhkan", "val1" => "Crudelia", "val2" => "positif"),
            array("val0" => "Tidak ada lagi cara yang benar ataupun salah untuk menghasilkan uang. Yang ada hanya cara mudah dan susah", "val1" => "Egoism", "val2" => "positif"),
            array("val0" => "Pembalasan dendam tidak memberikan kepuasan", "val1" => "Frustalia", "val2" => "positif"),
            array("val0" => "Sebagian besar orang layak dihormati", "val1" => "Machiavellianism", "val2" => "positif"),
            array("val0" => "Saya hampir tidak tahan jika orang lain menjadi pusat perhatian", "val1" => "Narcissism", "val2" => "positif"),
            array("val0" => "Saya selalu berusaha untuk tidak menyakiti orang lain dalam mengejar tujuan-tujuan saya", "val1" => "Psychopathy", "val2" => "positif"),

            array("val0" => "Dibandingkan orang lain, saya tidak layak untuk mendapatkan banyak hal dalam kehidupan", "val1" => "Psychological Entitlement", "val2" => "negatif"),
            array("val0" => "Saya benci melihat orang lain kecewa", "val1" => "Sadism", "val2" => "negatif"),
            array("val0" => "Jika dalam bisnis seseorang membuat kesalahan yang menguntungkan anda, tidak apa-apa tidak memberitahu mereka tentang hal itu karena itu adalah kesalahan mereka", "val1" => "Moral Disengagement", "val2" => "positif"),
            array("val0" => "Saya mencoba untuk mendahulukan diri saya terlebih dahulu, meskipun ini mempersulit orang lain", "val1" => "Self Centeredness", "val2" => "positif"),
            array("val0" => "Jika saya menentang pemilihan pejabat, maka saya akan senang melihatnya gagal meskipun kejatuhannya menyakiti komunitas saya", "val1" => "Spitefulness", "val2" => "positif"),
            array("val0" => "Melakukan perbuatan baik membawa kegembiraan di hati", "val1" => "Crudelia", "val2" => "positif"),
            array("val0" => "Seseorang harus mematuhi hukum, tidak peduli betapa ini menghambat ambisi pribadi mereka", "val1" => "Egoism", "val2" => "negatif"),
            array("val0" => "Saya senang membuat beberapa orang menderita, meskipun ini berarti saya akan masuk neraka bersama mereka", "val1" => "Frustalia", "val2" => "positif"),
            array("val0" => "Tidak peduli seberapa banyak yang telah saya miliki, saya tidak bisa merasa sepenuhnya puas.", "val1" => "Greed", "val2" => "positif"),
            array("val0" => "Betapa bijaknya untuk mengumpulkan informasi yang kelak dapat kita gunakan untuk melawan orang lain", "val1" => "Machiavellianism", "val2" => "positif"),
            array("val0" => "Melihat kegagalan saingan saya, tidak membuat saya merasa senang", "val1" => "Narcissism", "val2" => "positif"),
            array("val0" => "Saya tidak ingin orang-orang takut pada saya atau dorongan-dorongan saya", "val1" => "Psychopathy", "val2" => "negatif"),
            array("val0" => "Seseorang yang menyakiti saya tidak dapat mengandalkan simpati saya", "val1" => "Psychological Entitlement", "val2" => "positif"),
            array("val0" => "Saya menghindari mempermalukan orang lain", "val1" => "Sadism", "val2" => "positif"),
            array("val0" => "Orang-orang yang diperlakukan semena-mena biasanya melakukan sesuatu untuk menunjukan diri mereka", "val1" => "Moral Disengagement", "val2" => "negatif"),
            array("val0" => "Saya tidak akan mengejar apa yang saya inginkan jika ini menyebabkan masalah bagi orang lain", "val1" => "Self Centeredness", "val2" => "positif"),
            array("val0" => "Saya bersedia menerima satu pukulan jika orang yang tidak saya sukai menerima dua pukulan", "val1" => "Spitefulness", "val2" => "positif"),
            array("val0" => "Cerita-cerita mengenai kejujuran dan kebaikan hanya bertujuan untuk membuat orang bingung dan menjadi bodoh", "val1" => "Crudelia", "val2" => "positif"),
            array("val0" => "Akan sulit membuat sebuah kemajuan jika tidak mengorbankan beberapa hal", "val1" => "Egoism", "val2" => "positif"),
            array("val0" => "Pembalasan dendam yang menuntut waktu persiapan yang panjang membuahkan hasil yang lebih memuaskan", "val1" => "Frustalia", "val2" => "positif"),

            array("val0" => "Hampir dalam semua hal, kita perlu untuk merasa cukup", "val1" => "Greed", "val2" => "negatif "),
            array("val0" => "Pastikan bahwa rencana yang Anda buat menguntungkan Anda, bukan orang lain", "val1" => "Machiavellianism", "val2" => "positif "),
            array("val0" => "Saya tidak haus kekuasaan", "val1" => "Narcissism", "val2" => "positif "),
            array("val0" => "Kesuksesan adalah milik orang yang kuat dan bisa bertahan. Saya tidak peduli dengan orang yang gagal", "val1" => "Psychopathy", "val2" => "positif "),
            array("val0" => "Saya cenderung untuk memaafkan perlakuan-perlakuan buruk yang pernah saya alami", "val1" => "Psychological Entitlement", "val2" => "positif "),
            array("val0" => "Saya akan sangat menyesal jika saya menyakiti orang lain", "val1" => "Sadism", "val2" => "positif "),
            array("val0" => "Tidak masalah untuk memperlakukan dengan buruk seseorang yang berperilaku seperti bajingan", "val1" => "Moral Disengagement", "val2" => "positif "),
            array("val0" => "Saya merasa bersalah jika saya membuat orang lain kecewa", "val1" => "Self Centeredness", "val2" => "positif "),
            array("val0" => "Kadang dibutuhkan sedikit pengorbanan dari diri saya untuk bisa menolong orang lain yang membutuhkan", "val1" => "Spitefulness", "val2" => "positif "),
            array("val0" => "Membuat orang lain merasa tidak nyaman dengan keadaan dirinya tidak membuat saya merasa lebih baik", "val1" => "Sadism", "val2" => "positif ")
        );

        $kode = 'part5_2';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 5.2',
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

        // $tespart5_2 = 'tespart5_2';
        // DB::table('ujian')->insert([
        //     'kode' => $tespart5_2,
        //     'nama' => 'Part 5.2',
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
            'label' => 'part 5.2.',
            'urutan' => '1',
            'intruksi' => 'PETUNJUK<br>
Bacalah semua instruksi ini dengan teliti. Persoalan berikut ini terdiri atas 70 pernyataan. Bacalah masing-masing pernyataan dengan hati-hati dan pilihlah satu jawaban yang paling tepat untuk menyatakan persetujuan Anda. Anda diminta untuk menentukan satu jawaban dari lima alternatif berikut: Sangat Tidak Setuju (STS), Tidak Setuju (TS), Netral (N), Setuju (S), dan Sangat Setuju (SS)<br>. 

Tidak ada jawaban benar atau salah. Deskripsikan diri anda secara jujur dan nyatakan pendapat anda seakurat mungkin. Anda harus menjawab semua persoalan yang ada tanpa terlewatkan. Waktu yang disediakan 13 menit.<br>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
//         DB::table('intruksi_ujians')->insert([
//             'kode' => $tespart5_2,
//             'label' => 'part 5.2.',
//             'urutan' => '1',
//             'intruksi' => 'PETUNJUK<br>
// Bacalah semua instruksi ini dengan teliti. Persoalan berikut ini terdiri atas 70 pernyataan. Bacalah masing-masing pernyataan dengan hati-hati dan pilihlah satu jawaban yang paling tepat untuk menyatakan persetujuan Anda. Anda diminta untuk menentukan satu jawaban dari lima alternatif berikut: Sangat Tidak Setuju (STS), Tidak Setuju (TS), Netral (N), Setuju (S), dan Sangat Setuju (SS)<br>. 

// Tidak ada jawaban benar atau salah. Deskripsikan diri anda secara jujur dan nyatakan pendapat anda seakurat mungkin. Anda harus menjawab semua persoalan yang ada tanpa terlewatkan. Waktu yang disediakan 13 menit.<br>',
//             'created_at' => Carbon::now(),
//             'updated_at' => Carbon::now()
//         ]);


        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.jpg',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'kode_ujian' => $tespart5_2,
            //     'kode_merge_ujian' => 'tes_merge_ujian_2',
            //     'banner' => 'banner2.jpg',
            //     'instruksi_ujian' => 'Pastikan koneksi stabil.',
            //     'urutan' => 9,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]
        ]);

        foreach ($kuisoner as $number => $answer) {


            $DetailKuisoner = DetailKuisoner::create([
                'kode' => $kode,
                'soal' => $answer['val0'],
                'item' => $answer['val2'],
                'jenis_jawaban_kuesioner_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $sekala = Sekala::where('sekala', $answer['val1'])->first();
            DetailKuisonerSekala::create([
                'detail_kuisoner_id' => $DetailKuisoner->id,
                'kode_sekala' => $sekala ? $sekala->kode : $answer['val1'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        $counter = 0;
        foreach ($kuisoner as $number => $answer) {
            if ($counter >= 3) break;
            $counter++;

            // $DetailKuisoner = DetailKuisoner::create([
            //     'kode' => $tespart5_2,
            //     'soal' => $answer['val0'],
            //     'item' => $answer['val2'],
            //     'jenis_jawaban_kuesioner_id' => 1,
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);
            // $sekala = Sekala::where('sekala', $answer['val1'])->first();
            // DetailKuisonerSekala::create([
            //     'detail_kuisoner_id' => $DetailKuisoner->id,
            //     'kode_sekala' =>  $sekala ? $sekala->kode : $answer['val1'],
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);
        }
    }
}
