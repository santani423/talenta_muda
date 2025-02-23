<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class InterpretasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "domain" => "Egoism",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk mementingkan kenikmatan diri sendiri yang mengorbankan kesejahteraan masyarakat",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk mementingkan kenikmatan diri sendiri yang mengorbankan kesejahteraan masyarakat",
            ],
            [
                "domain" => "Greed",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah terhadap perasaan tidak pernah merasa cukup, yang didukung dengan keinginan untuk mendapatkan lebih",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi terhadap perasaan tidak pernah merasa cukup, yang didukung dengan keinginan untuk mendapatkan lebih",
            ],
            [
                "domain" => "Machiavellianism",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk melakukan manipulasi terhadap orang lain yang disebabkan oleh cara memandang dunia dengan sinis, berorientasi pada keuntungan diri sendiri, dan tidak peduli dengan perasaan orang lain.",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk melakukan manipulasi terhadap orang lain yang disebabkan oleh cara memandang dunia dengan sinis, berorientasi pada keuntungan diri sendiri, dan tidak peduli dengan perasaan orang lain",
            ],
            [
                "domain" => "Moral Disengagement",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk melakukan perilaku yang tidak sesuai dengan etika tanpa merasa bersalah yang merupakan hasil dari proses berpikir dalam pengambilan keputusan (tidak akan melakukan tindakan yang tidak sesuai dengan etika walaupun ada dorongan dari keadaan lingkungan)",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk melakukan perilaku yang tidak sesuai dengan etika tanpa merasa bersalah yang merupakan hasil dari proses berpikir dalam pengambilan keputusan (akan melakukan tindakan yang tidak sesuai dengan etika karena dorongan keadaan lingkungan)",
            ],
            [
                "domain" => "Narcissism",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk mendapatkan pengaguman sosial (seperti pujian, pengakuan di depan orang banyak) dengan maksud untuk membanggakan dirinya dan tidak terlihat gagal dalam bersosialisasi sebagai bentuk dari pertahanan terhadap harga diri.",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk mendapatkan pengaguman sosial (seperti pujian, pengakuan di depan orang banyak) dengan maksud untuk membanggakan dirinya dan tidak terlihat gagal dalam bersosialisasi sebagai bentuk dari pertahanan terhadap harga diri.",
            ],
            [
                "domain" => "Psychological Entitlement",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk merasa bahwa diri sendiri memiliki hak lebih banyak atau lebih besar dibandingkan orang lain.",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk merasa bahwa diri sendiri memiliki hak lebih banyak atau lebih besar dibandingkan orang lain.",
            ],
            [
                "domain" => "Psychopathy",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk menyakiti orang lain yang disebabkan oleh rendahnya afektif (contoh, sifat tidak peduli terhadap orang lain, tidak memiliki belas kasih) dan kurangnya kontrol diri (contoh, perilaku impulsif)",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk menyakiti orang lain yang disebabkan oleh rendahnya afektif (seperti sifat tidak peduli terhadap orang lain, tidak memiliki belas kasih) dan kurangnya kontrol diri (seperti perilaku impulsif)",
            ],
            [
                "domain" => "Sadism",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk melakukan tindakan sadis, merendahkan, atau perilaku agresif untuk kesenangan diri sendiri atau menguasai orang lain",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk melakukan tindakan sadis, merendahkan, atau perilaku agresif untuk kesenangan diri sendiri atau menguasai orang lain",
            ],
            [
                "domain" => "Self Centeredness",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah dalam rasa tidak peka terhadap penderitaan dan kebutuhan orang lain (mengabaikan kebutuhan orang lain)",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi dalam rasa tidak peka terhadap penderitaan dan kebutuhan orang lain (mengabaikan kebutuhan orang lain)",
            ],
            [
                "domain" => "Spitefulness",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk menyakiti orang lain untuk kesenangan diri sendiri walaupun hal tersebut dapat menyakiti dirinya",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk menyakiti orang lain untuk kesenangan diri sendiri walaupun hal tersebut dapat menyakiti / merugikan dirinya",
            ],
            [
                "domain" => "Crudelia",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk melakukan tindakan amoral yang didalamnya terdapat perilaku kejam",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk melakukan tindakan amoral yang didalamnya terdapat perilaku kejam",
            ],
            [
                "domain" => "Frustalia",
                "skor_sangat_rendah" => "Memiliki kecenderungan rendah untuk melakukan tindakan amoral yang disebabkan oleh rasa frustasi",
                "skor_sangat_tinggi" => "Memiliki kecenderungan tinggi untuk melakukan tindakan amoral yang disebabkan oleh rasa frustasi",
            ],
        ];
        DB::table('interpretasis')->insert($data);
    }
}
// php artisan db:seed --class=InterpretasiSeeder
