<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = array(
            array("val0"=>"Egoism", "val1"=>"Memiliki kecenderungan rendah  untuk mementingkan kenikmatan diri sendiri yang mengorbankan kesejahteraan masyarakat", "val2"=>"Memiliki kecenderungan tinggi  untuk mementingkan kenikmatan diri sendiri yang mengorbankan kesejahteraan masyarakat", "val3"=>"EGO"),
            array("val0"=>"Greed", "val1"=>"Memiliki kecenderungan rendah terhadap perasaan tidak pernah merasa cukup, yang didukung dengan keinginan untuk mendapatkan lebih", "val2"=>"Memiliki kecenderungan tinggi terhadap perasaan tidak pernah merasa cukup, yang didukung dengan keinginan untuk mendapatkan lebih", "val3"=>"GRD"),
            array("val0"=>"Machiavellianism", "val1"=>"Memiliki kecenderungan rendah untuk melakukan manipulasi terhadap orang lain yang disebabkan oleh cara memandang dunia dengan sinis, berorientasi pada keuntungan diri sendiri, dan tidak peduli dengan perasaan orang lain.", "val2"=>"Memiliki kecenderungan tinggi untuk melakukan manipulasi terhadap orang lain yang disebabkan oleh cara memandang dunia dengan sinis, berorientasi pada keuntungan diri sendiri, dan tidak peduli dengan perasaan orang lain", "val3"=>"MACH"),
            array("val0"=>"Moral Disengagement", "val1"=>"Memiliki kecenderungan rendah untuk melakukan perilaku yang tidak sesuai dengan etika tanpa merasa bersalah yang merupakan hasil dari proses berpikir dalam pengambilan keputusan (tidak akan melakukan tindakan yang tidak sesuai dengan etika walaupun ada dorongan dari keadaan lingkungan) ", "val2"=>"Memiliki kecenderungan tinggi  untuk melakukan perilaku yang tidak sesuai dengan etika tanpa merasa bersalah yang merupakan hasil dari proses berpikir dalam pengambilan keputusan (akan melakukan tindakan yang tidak sesuai dengan etika karena dorongan keadaan lingkungan)", "val3"=>"MD"),
            array("val0"=>"Narcissism", "val1"=>"Memiliki kecenderungan rendah untuk mendapatkan pengaguman sosial (seperti pujian, pengakuan di depan orang banyak) dengan maksud untuk membanggakan dirinya dan tidak terlihat gagal dalam bersosialisasi sebagai bentuk dari pertahanan terhadap harga diri.", "val2"=>"Memiliki kecenderungan tinggi untuk mendapatkan pengaguman sosial (seperti pujian, pengakuan di depan orang banyak) dengan maksud untuk membanggakan dirinya dan tidak terlihat gagal dalam bersosialisasi sebagai bentuk dari pertahanan terhadap harga diri.", "val3"=>"NARC"),
            array("val0"=>"Psychological Entitlement", "val1"=>"Memiliki kecenderungan rendah untuk merasa bahwa diri sendiri memiliki hak lebih banyak atau lebih besar dibandingkan orang lain.", "val2"=>"Memiliki kecenderungan tinggi untuk merasa bahwa diri sendiri memiliki hak lebih banyak atau lebih besar dibandingkan orang lain. ", "val3"=>"PE"),
            array("val0"=>"Psychopathy", "val1"=>"Memiliki kecenderungan rendah untuk menyakiti orang lain yang disebabkan oleh rendahnya afektif (contoh, sifat tidak peduli terhadap orang lain, tidak memiliki belas kasih) dan kurangnya kontrol diri (contoh, perilaku impulsif)", "val2"=>"Memiliki kecenderungan tinggi untuk menyakiti orang lain yang disebabkan oleh rendahnya afektif (seperti sifat tidak peduli terhadap orang lain, tidak memiliki belas kasih) dan kurangnya kontrol diri (seperti perilaku impulsif)", "val3"=>"PSY"),
            array("val0"=>"Sadism", "val1"=>"Memiliki kecenderungan rendah untuk melakukan tindakan sadis, merendahkan, atau perilaku agresif untuk kesenangan diri sendiri atau menguasai orang lain", "val2"=>"Memiliki kecenderungan tinggi untuk melakukan tindakan sadis, merendahkan, atau perilaku agresif untuk kesenangan diri sendiri atau menguasai orang lain", "val3"=>"SAD"),
            array("val0"=>"Self Centeredness", "val1"=>"Memiliki kecenderungan rendah dalam rasa tidak peka terhadap penderitaan dan kebutuhan orang lain (mengabaikan kebutuhan orang lain)", "val2"=>"Memiliki kecenderungan tinggi dalam rasa tidak peka terhadap penderitaan dan kebutuhan orang lain (mengabaikan kebutuhan orang lain)", "val3"=>"SC"),
            array("val0"=>"Spitefulness", "val1"=>"Memiliki kecenderungan rendah untuk menyakiti orang lain untuk kesenangan diri sendiri walaupun hal tersebut dapat menyakiti dirinya", "val2"=>"Memiliki kecenderungan tinggi untuk menyakiti orang lain ", "val3"=>"SPITE"),
            array("val0"=>"Crudelia", "val1"=>"Memiliki kecenderungan rendah untuk melakukan tindakan amoral yang didalamnya terdapat perilaku kejam", "val2"=>"Memiliki kecenderungan tinggi untuk melakukan tindakan amoral yang didalamnya terdapat perilaku kejam", "val3"=>"CRUD"),
            array("val0"=>"Frustalia", "val1"=>"Memiliki kecenderungan rendah untuk melakukan tindakan amoral yang disebabkan oleh rasa frustasi ", "val2"=>"Memiliki kecenderungan tinggi untuk melakukan tindakan amoral yang disebabkan oleh rasa frustasi", "val3"=>"FRUST"),
            array("val0"=>"L", "val1"=>"desc","val2"=>"desc", "val3"=>"L"),
            array("val0"=>"Mt", "val1"=>"desc","val2"=>"desc", "val3"=>"MT"),
            array("val0"=>"TRT", "val1"=>"desc","val2"=>"desc", "val3"=>"TRT"),
            array("val0"=>"TRT", "val1"=>"desc","val2"=>"desc", "val3"=>"TRT"),
            array("val0"=>"TRT/TRT1", "val1"=>"desc","val2"=>"desc", "val3"=>"TRT1"),
            array("val0"=>"TRT/TRT2", "val1"=>"desc","val2"=>"desc", "val3"=>"TRT2")
        );


        foreach ($array as $key => $value) {
            DB::table('sekalas')->insert([
                'sekala' => $value['val0'],
                'kode' => $value['val3'],
                'sekala_tinggi' => $value['val1'],
                'sekala_rendah' => $value['val2'],
            ]);
        }
    }
}
