<?php

namespace Database\Seeders;

use App\Models\DetailKuisoner;
use App\Models\DetailKuisonerFacet;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Part5_1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kuisoner = array(
            array("val0" => "Saya jarang merasa cemas.", "val1" => "n1", "val2" => "anxiety", "val3" => "neg"),
            array("val0" => "Saya menyukai kebanyakan orang yang saya temui.", "val1" => "e1", "val2" => "warmth", "val3" => "pos"),
            array("val0" => "Saya memiliki imajinasi yang sangat aktif.", "val1" => "o1", "val2" => "fantasy", "val3" => "pos"),
            array("val0" => "Saya cenderung skeptis terhadap niat orang lain.", "val1" => "a1", "val2" => "trust ", "val3" => "neg"),
            array("val0" => "Saya terkenal sebagai pengambil keputusan yang hati-hati dan logis.", "val1" => "c1", "val2" => "competence", "val3" => "pos"),
            array("val0" => "Saya sering merasa marah atas perlakuan orang terhadap saya.", "val1" => "n2", "val2" => "angry hostility", "val3" => "pos"),
            array("val0" => "Saya menghindari kerumunan orang.", "val1" => "e2", "val2" => "gregariousness", "val3" => "neg"),
            array("val0" => "Estetika dan seni tidak begitu penting bagi saya.", "val1" => "o2", "val2" => "aesthetic", "val3" => "neg"),
            array("val0" => "Saya bukan orang yang licik atau manipulatif.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "pos"),
            array("val0" => "Saya lebih suka mempertimbangkan berbagai alternatif daripada membuat rencana tetap dari awal.", "val1" => "c2", "val2" => "order", "val3" => "neg"),
            array("val0" => "Saya jarang merasa kesepian atau sedih.", "val1" => "n3", "val2" => "depression", "val3" => "neg"),
            array("val0" => "Saya dominan, kuat, dan asertif.", "val1" => "e3", "val2" => "assertiveness", "val3" => "pos"),
            array("val0" => "Tanpa emosi yang kuat, hidup akan terasa membosankan bagi saya.", "val1" => "o3", "val2" => "feelings", "val3" => "pos"),
            array("val0" => "Beberapa orang menganggap saya egois dan perhatian pada diri sendiri.", "val1" => "a3", "val2" => "altruism", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk menyelesaikan semua tugas dengan tanggung jawab penuh.", "val1" => "c3", "val2" => "dutifulness", "val3" => "pos"),
            array("val0" => "Ketika berinteraksi dengan orang lain, saya selalu kuatir untuk membuat malu diri saya di hadapan mereka. ", "val1" => "n4", "val2" => "self consciousness", "val3" => "pos"),
            array("val0" => "Saya bekerja dan bermain dengan gaya yang santai.", "val1" => "e4", "val2" => "activity", "val3" => "neg"),
            array("val0" => "Saya memiliki kebiasaan-kebiasaan yang teratur.", "val1" => "o4", "val2" => "actions", "val3" => "neg"),
            array("val0" => "Saya lebih suka berkolaborasi daripada bersaing.", "val1" => "a4", "val2" => "compliance", "val3" => "pos"),
            array("val0" => "Saya adalah orang yang 'cuek' dan tidak serius.", "val1" => "c4", "val2" => "achievement striving", "val3" => "neg"),
            array("val0" => "Saya jarang terjebak dalam keinginan berlebihan.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "neg"),
            array("val0" => "Saya sering merindukan hal-hal yang menarik dan menggugah semangat", "val1" => "e5", "val2" => "excitement seeking", "val3" => "pos"),
            array("val0" => "Saya suka bermain dengan teori-teori dan ide-ide abstrak.", "val1" => "o5", "val2" => "ideas", "val3" => "pos"),
            array("val0" => "Saya tidak ragu untuk membanggakan kemampuan dan prestasi saya.", "val1" => "a5", "val2" => "modesty", "val3" => "neg"),
            array("val0" => "Saya pandai mengatur waktu saya, sehingga dapat menyelesaikan tugas tepat waktu.", "val1" => "c5", "val2" => "self-discipline", "val3" => "pos"),
            array("val0" => "Saya sering merasa tidak berdaya dan ingin mengandalkan bantuan orang lain.", "val1" => "n6", "val2" => "vulnerability", "val3" => "pos"),
            array("val0" => "Saya tidak pernah merasakan kegembiraan yang luar biasa hingga melompat.", "val1" => "e6", "val2" => "positive emotions", "val3" => "neg"),
            array("val0" => "Saya yakin membiarkan murid mendengarkan pembicara kontroversial hanya akan  membingungkan dan menyesatkan mereka.", "val1" => "o6", "val2" => "values", "val3" => "neg"),
            array("val0" => "Saya pikir pemimpin politik perlu lebih peka terhadap sisi kemanusiaan dari kebijakan mereka.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "pos"),
            array("val0" => "Selama ini, saya telah melakukan banyak kebodohan.", "val1" => "c6", "val2" => "deliberation ", "val3" => "neg"),
            array("val0" => "Saya mudah merasa takut.", "val1" => "n1", "val2" => "anxiety", "val3" => "pos"),
            array("val0" => "Berbincang-bincang dengan orang lain tidak terlalu menyenangkan bagi saya.", "val1" => "e1", "val2" => "warmth", "val3" => "neg"),
            array("val0" => "Saya berupaya untuk senantiasa berpikir realistis dan menghindari khayalan berlebihan.", "val1" => "o1", "val2" => "fantasy", "val3" => "neg"),
            array("val0" => "Saya meyakini bahwa kebanyakan orang memiliki niat baik.", "val1" => "a1", "val2" => "trust ", "val3" => "pos"),
            array("val0" => "Saya tidak terlalu menganggap serius kewajiban saya sebagai warga negara, termasuk dalam pemilihan umum.", "val1" => "c1", "val2" => "competence", "val3" => "neg"),
            array("val0" => "Saya memiliki sifat yang tenang dan jarang marah.", "val1" => "n2", "val2" => "angry hostility", "val3" => "neg"),
            array("val0" => "Saya  senang berada di keramaian.", "val1" => "e2", "val2" => "gregariousness", "val3" => "pos"),
            array("val0" => "Terkadang saya sangat terpesona oleh musik yang saya dengar", "val1" => "o2", "val2" => "aesthetic", "val3" => "pos"),
            array("val0" => "Jika perlu, saya bersedia menggunakan taktik manipulatif untuk mencapai tujuan saya.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "neg"),
            array("val0" => "Saya menjaga barang-barang saya tetap rapi dan bersih.", "val1" => "c2", "val2" => "order", "val3" => "pos"),
            array("val0" => "Terkadang, saya merasa bahwa diri saya tidak berharga sama sekali.", "val1" => "n3", "val2" => "depression", "val3" => "pos"),
            array("val0" => "Saya terkadang merasa tidak mampu mengungkapkan apa yang saya inginkan.", "val1" => "e3", "val2" => "assertiveness", "val3" => "neg"),
            array("val0" => "Saya jarang mengalami emosi yang kuat.", "val1" => "o3", "val2" => "feelings", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk bersikap sopan terhadap setiap orang.", "val1" => "a3", "val2" => "altruism", "val3" => "pos"),
            array("val0" => "Kadang-kadang, saya tidak dapat diandalkan seperti yang seharusnya.", "val1" => "c3", "val2" => "dutifulness", "val3" => "neg"),
            array("val0" => "Saya jarang merasa canggung dalam interaksi sosial.", "val1" => "n4", "val2" => "self consciousness", "val3" => "neg"),
            array("val0" => "Ketika saya melakukan sesuatu, saya melakukannya dengan sepenuh tenaga.", "val1" => "e4", "val2" => "activity", "val3" => "pos"),
            array("val0" => "Saya tertarik untuk belajar dan mengembangkan hobi-hobi baru.", "val1" => "o4", "val2" => "actions", "val3" => "pos"),
            array("val0" => "Saya dapat menggunakan kata-kata tajam dan sarkastik jika diperlukan.", "val1" => "a4", "val2" => "compliance", "val3" => "neg"),
            array("val0" => "Saya memiliki serangkaian tujuan yang jelas dan berusaha mencapainya secara sistematis.", "val1" => "c4", "val2" => "achievement striving", "val3" => "pos"),
            array("val0" => "Saya sulit untuk menahan keinginan saya yang kuat.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "pos"),
            array("val0" => "Saya tidak akan menikmati liburan di kota yang ramai dan sibuk.", "val1" => "e5", "val2" => "excitement seeking", "val3" => "neg"),
            array("val0" => "Diskusi tentang masalah filsafat cenderung membosankan bagi saya.", "val1" => "o5", "val2" => "ideas", "val3" => "neg"),
            array("val0" => "Saya lebih suka tidak menonjolkan diri atau prestasi saya.", "val1" => "a5", "val2" => "modesty", "val3" => "pos"),
            array("val0" => "Saya sering membuang waktu sebelum mulai bekerja.", "val1" => "c5", "val2" => "self-discipline", "val3" => "neg"),
            array("val0" => "Saya merasa mampu mengatasi sebagian besar masalah saya.", "val1" => "n6", "val2" => "vulnerability", "val3" => "neg"),
            array("val0" => "Kadang-kadang saya merasa sangat gembira atau luar biasa bahagia .", "val1" => "e6", "val2" => "positive emotions", "val3" => "pos"),
            array("val0" => "Saya percaya bahwa hukum dan kebijakan sosial harus berubah sesuai dengan kebutuhan zaman.", "val1" => "o6", "val2" => "values", "val3" => "pos"),
            array("val0" => "Saya adalah orang yang rasional dan realistis yang tidak mudah terbawa emosi dalam bersikap. ", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "neg"),
            array("val0" => "Saya mempertimbangkan berbagai hal sebelum membuat keputusan.", "val1" => "c6", "val2" => "deliberation ", "val3" => "pos"),
            array("val0" => "Saya jarang merasa takut atau cemas.", "val1" => "n1", "val2" => "anxiety", "val3" => "neg"),
            array("val0" => "Saya adalah orang yang hangat dan ramah.", "val1" => "e1", "val2" => "warmth", "val3" => "pos"),
            array("val0" => "Saya memiliki imajinasi yang aktif.", "val1" => "o1", "val2" => "fantasy", "val3" => "pos"),
            array("val0" => "Saya curiga bahwa kebanyakan orang akan mencoba memanfaatkan saya.", "val1" => "a1", "val2" => "trust ", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk mendapatkan informasi dan umumnya membuat keputusan dengan cerdas.", "val1" => "c1", "val2" => "competence", "val3" => "pos"),
            array("val0" => "Saya gampang merasa marah dan tersinggung dengan cepat.", "val1" => "n2", "val2" => "angry hostility", "val3" => "pos"),
            array("val0" => "Umumnya, saya lebih suka bekerja sendiri.", "val1" => "e2", "val2" => "gregariousness", "val3" => "neg"),
            array("val0" => "Saya tidak tertarik dan merasa bosan menyaksikan balet atau tarian modern.", "val1" => "o2", "val2" => "aesthetic", "val3" => "neg"),
            array("val0" => "Saya tidak bisa menipu orang lain meskipun saya menginginkannya.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "pos"),
            array("val0" => "Saya tidak terlalu sistematis.", "val1" => "c2", "val2" => "order", "val3" => "neg"),
            array("val0" => "Saya jarang merasa sedih atau tertekan.", "val1" => "n3", "val2" => "depression", "val3" => "neg"),
            array("val0" => "Saya sering menjadi pemimpin dalam kelompok-kelompok yang saya ikuti.", "val1" => "e3", "val2" => "assertiveness", "val3" => "pos"),
            array("val0" => "Bagaimana cara saya menghayati sesuatu, merupakan hal penting bagi saya.", "val1" => "o3", "val2" => "feelings", "val3" => "pos"),
            array("val0" => "Beberapa orang merasa bahwa saya bersikap dingin dan selalu mempertimbangkan segala sesuatu dengan penuh perhitungan.", "val1" => "a3", "val2" => "altruism", "val3" => "neg"),
            array("val0" => "Saya membayar hutang saya tepat waktu.", "val1" => "c3", "val2" => "dutifulness", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya merasa sedemikian malu hingga ingin bersembunyi.", "val1" => "n4", "val2" => "self consciousness", "val3" => "pos"),
            array("val0" => "Saya bekerja dengan lambat tetapi mantap", "val1" => "e4", "val2" => "activity", "val3" => "neg"),
            array("val0" => "Saya menggunakan cara yang sama untuk melakukan sesuatu secara berulangkali jika cara tersebut tepat.", "val1" => "o4", "val2" => "actions", "val3" => "neg"),
            array("val0" => "Saya ragu-ragu menunjukkan kemarahan saya, bahkan dengan alasan yang tepat.", "val1" => "a4", "val2" => "compliance", "val3" => "pos"),
            array("val0" => "Saya cenderung mengabaikan program pengembangan diri setelah beberapa waktu.", "val1" => "c4", "val2" => "achievement striving", "val3" => "neg"),
            array("val0" => "Saya seringkali mampu untuk melawan godaan.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "neg"),
            array("val0" => "Kadang-kadang saya melakukan sesuatu hanya untuk iseng atau merasakan sensasinya.", "val1" => "e5", "val2" => "excitement seeking", "val3" => "pos"),
            array("val0" => "Saya suka memecahkan masalah atau teka-teki.", "val1" => "o5", "val2" => "ideas", "val3" => "pos"),
            array("val0" => "Saya pikir saya lebih baik dari kebanyakan orang.", "val1" => "a5", "val2" => "modesty", "val3" => "neg"),
            array("val0" => "Saya adalah pekerja yang produktif dan selalu mampu menyelesaikan pekerjaan saya.", "val1" => "c5", "val2" => "self-discipline", "val3" => "pos"),
            array("val0" => "Terkadang saya merasa akan hancur ketika berada di bawah tekanan besar.", "val1" => "n6", "val2" => "vulnerability", "val3" => "pos"),
            array("val0" => "Saya bukan  seorang optimis yang ceria.", "val1" => "e6", "val2" => "positive emotions", "val3" => "neg"),
            array("val0" => "Saya yakin bahwa seharusnya kita mendasarkan pada kekuatan agama yang diyakini dalam membuat keputusan  moral.", "val1" => "o6", "val2" => "values", "val3" => "neg"),
            array("val0" => "Saya merasa kita tidak akan dapat melakukan banyak hal bagi orang miskin dan jompo.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya bertindak tanpa berpikir terlebih dahulu.", "val1" => "c6", "val2" => "deliberation ", "val3" => "neg"),
            array("val0" => "Saya sering merasa tegang dan gugup.", "val1" => "n1", "val2" => "anxiety", "val3" => "pos"),
            array("val0" => "Banyak orang menganggap saya agak dingin dan menjaga jarak.", "val1" => "e1", "val2" => "warmth", "val3" => "neg"),
            array("val0" => "Saya tidak suka melamun untuk membuang waktu.", "val1" => "o1", "val2" => "fantasy", "val3" => "neg"),
            array("val0" => "Saya pikir bahwa kebanyakan orang yang berhubungan dengan saya adalah  jujur dan dapat dipercaya.", "val1" => "a1", "val2" => "trust ", "val3" => "pos"),
            array("val0" => "Saya sering terjun ke dalam situasi tanpa persiapan penuh.", "val1" => "c1", "val2" => "competence", "val3" => "neg"),
            array("val0" => "Saya tidak dianggap mudah marah atau jengkel.", "val1" => "n2", "val2" => "angry hostility", "val3" => "neg"),
            array("val0" => "Saya membutuhkan kehadiran orang lain jika saya sendirian untuk waktu yang lama.", "val1" => "e2", "val2" => "gregariousness", "val3" => "pos"),
            array("val0" => "Saya sangat tertarik dengan pola-pola dalam seni dan alam.", "val1" => "o2", "val2" => "aesthetic", "val3" => "pos"),
            array("val0" => "Saya pikir bersikap jujur sepenuhnya adalah cara yang kurang baik dalam berbisnis.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "neg"),
            array("val0" => "Saya suka meletakkan barang-barang pada tempat yang seharusnya agar mudah dicari. ", "val1" => "c2", "val2" => "order", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya merasa sangat bersalah atau berdosa.", "val1" => "n3", "val2" => "depression", "val3" => "pos"),
            array("val0" => "Di dalam pertemuan, saya cenderung lebih banyak mendengarkan orang lain daripada berbicara .", "val1" => "e3", "val2" => "assertiveness", "val3" => "neg"),
            array("val0" => "Saya jarang memperhatikan perasaan saya pada waktu tertentu.", "val1" => "o3", "val2" => "feelings", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk menjadi peka terhadap kebutuhan dan pandangan orang lain.", "val1" => "a3", "val2" => "altruism", "val3" => "pos"),
            array("val0" => "Saya terkadang curang saat bermain sendiri.", "val1" => "c3", "val2" => "dutifulness", "val3" => "neg"),
            array("val0" => "Mengalami ejekan atau cemoohan tidak membuat saya merasa terlalu malu.", "val1" => "n4", "val2" => "self consciousness", "val3" => "neg"),
            array("val0" => "Saya sering merasa memiliki terlalu banyak energi.", "val1" => "e4", "val2" => "activity", "val3" => "pos"),
            array("val0" => "Saya suka mencoba makanan-makanan baru dan eksotis.", "val1" => "o4", "val2" => "actions", "val3" => "pos"),
            array("val0" => "Jika saya tidak suka pada seseorang, saya akan menunjukkannya.", "val1" => "a4", "val2" => "compliance", "val3" => "neg"),
            array("val0" => "Saya bekerja keras untuk mencapai tujuan saya.", "val1" => "c4", "val2" => "achievement striving", "val3" => "pos"),
            array("val0" => "Ketika saya melihat makanan favorit saya, saya cenderung makan terlalu banyak.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "pos"),
            array("val0" => "Saya cenderung menghindari film-film yang menegangkan atau menakutkan.", "val1" => "e5", "val2" => "excitement seeking", "val3" => "neg"),
            array("val0" => "Kadang-kadang saya kehilangan minat dalam pembahasan teoritis yang sangat abstrak.", "val1" => "o5", "val2" => "ideas", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk bersikap rendah hati.", "val1" => "a5", "val2" => "modesty", "val3" => "pos"),
            array("val0" => "Saya sulit memaksa diri saya untuk melakukan hal yang seharusnya.", "val1" => "c5", "val2" => "self-discipline", "val3" => "neg"),
            array("val0" => "Saya tetap tenang dalam situasi darurat.", "val1" => "n6", "val2" => "vulnerability", "val3" => "neg"),
            array("val0" => "Kadang-kadang saya merasa sangat bahagia.", "val1" => "e6", "val2" => "positive emotions", "val3" => "pos"),
            array("val0" => "Saya percaya perbedaan pandangan tentang benar dan salah pada kelompok masyarakat yang berbeda adalah sesuai bagi mereka.", "val1" => "o6", "val2" => "values", "val3" => "pos"),
            array("val0" => "Saya tidak simpatik terhadap pengemis.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "neg"),
            array("val0" => "Saya selalu mempertimbangkan konsekuensi sebelum bertindak.", "val1" => "c6", "val2" => "deliberation ", "val3" => "pos"),
            array("val0" => "Saya jarang merasa khawatir tentang masa depan.", "val1" => "n1", "val2" => "anxiety", "val3" => "neg"),
            array("val0" => "Saya benar-benar suka berbicara dengan orang lain.", "val1" => "e1", "val2" => "warmth", "val3" => "pos"),
            array("val0" => "Saya suka mengembangkan fantasi atau khayalan dan menjelajahi kemungkinan-kemungkinannya.", "val1" => "o1", "val2" => "fantasy", "val3" => "pos"),
            array("val0" => "Saya curiga ketika seseorang bertindak baik kepada saya.", "val1" => "a1", "val2" => "trust ", "val3" => "neg"),
            array("val0" => "Saya bangga atas pendapat saya yang bijaksana.", "val1" => "c1", "val2" => "competence", "val3" => "pos"),
            array("val0" => "Saya sering merasa kesal terhadap orang-orang di sekitar saya.", "val1" => "n2", "val2" => "angry hostility", "val3" => "pos"),
            array("val0" => "Saya lebih suka bekerja sendiri tanpa gangguan orang lain.", "val1" => "e2", "val2" => "gregariousness", "val3" => "neg"),
            array("val0" => "Puisi tidak berpengaruh pada saya.", "val1" => "o2", "val2" => "aesthetic", "val3" => "neg"),
            array("val0" => "Saya tidak suka dianggap munafik.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "pos"),
            array("val0" => "Saya tidak pernah bekerja secara terorganisir.", "val1" => "c2", "val2" => "order", "val3" => "neg"),
            array("val0" => "Saya cenderung menyalahkan diri sendiri jika sesuatu tidak berjalan sesuai rencana.", "val1" => "n3", "val2" => "depression", "val3" => "pos"),
            array("val0" => "Orang lain sering mengandalkan saya untuk membuat keputusan.", "val1" => "e3", "val2" => "assertiveness", "val3" => "pos"),
            array("val0" => "Saya memiliki beragam emosi atau perasaan.", "val1" => "o3", "val2" => "feelings", "val3" => "pos"),
            array("val0" => "Saya tidak dikenal sebagai orang yang dermawan.", "val1" => "a3", "val2" => "altruism", "val3" => "neg"),
            array("val0" => "Saya selalu memenuhi komitmen yang saya buat.", "val1" => "c3", "val2" => "dutifulness", "val3" => "pos"),
            array("val0" => "Saya sering merasa lebih rendah dari orang lain.", "val1" => "n4", "val2" => "self consciousness", "val3" => "pos"),
            array("val0" => "Saya tidak secepat atau seaktif orang lain. ", "val1" => "e4", "val2" => "activity", "val3" => "neg"),
            array("val0" => "Saya lebih suka berada di lingkungan yang sudah saya kenal.", "val1" => "o4", "val2" => "actions", "val3" => "neg"),
            array("val0" => "Jika dihina, saya berusaha untuk memaafkan dan melupakannya.", "val1" => "a4", "val2" => "compliance", "val3" => "pos"),
            array("val0" => "Saya tidak merasa terpacu untuk maju.", "val1" => "c4", "val2" => "achievement striving", "val3" => "neg"),
            array("val0" => "Saya jarang menyerah pada dorongan saya.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "neg"),
            array("val0" => "Saya suka berpetualang.", "val1" => "e5", "val2" => "excitement seeking", "val3" => "pos"),
            array("val0" => "Saya menikmati memecahkan teka-teki yang menantang secara kreatif.", "val1" => "o5", "val2" => "ideas", "val3" => "pos"),
            array("val0" => "Saya memiliki pandangan yang tinggi terhadap diri saya sendiri.", "val1" => "a5", "val2" => "modesty", "val3" => "neg"),
            array("val0" => "Saya biasanya menyelesaikan proyek yang saya mulai.", "val1" => "c5", "val2" => "self-discipline", "val3" => "pos"),
            array("val0" => "Saya sering kesulitan mengambil keputusan.", "val1" => "n6", "val2" => "vulnerability", "val3" => "pos"),
            array("val0" => "Saya tidak beranggapan bahwa diri saya 'periang'", "val1" => "e6", "val2" => "positive emotions", "val3" => "neg"),
            array("val0" => "Saya meyakini bahwa memegang teguh pada idealisme dan prinsip lebih penting daripada memiliki pikiran yang terbuka.", "val1" => "o6", "val2" => "values", "val3" => "neg"),
            array("val0" => "Saya percaya kebutuhan manusia harus diprioritaskan di atas pertimbangan ekonomi.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "pos"),
            array("val0" => "Saya sering melakukan sesuatu secara tiba-tiba.", "val1" => "c6", "val2" => "deliberation ", "val3" => "neg"),
            array("val0" => "Saya sering merasa cemas bahwa segala sesuatu tidak berjalan sebagaimana mestinya.", "val1" => "n1", "val2" => "anxiety", "val3" => "pos"),
            array("val0" => "Saya mudah tersenyum dan menjalin hubungan dengan orang asing.", "val1" => "e1", "val2" => "warmth", "val3" => "pos"),
            array("val0" => "Ketika pikiran saya mulai melantur, saya biasanya mencari kesibukan dan mulai fokus pada pekerjaan atau hal lain.", "val1" => "o1", "val2" => "fantasy", "val3" => "neg"),
            array("val0" => "Reaksi pertama saya adalah langsung percaya pada orang lain.", "val1" => "a1", "val2" => "trust ", "val3" => "pos"),
            array("val0" => "Saya merasa bahwa saya tidak pernah benar-benar berhasil dalam hal apa pun.", "val1" => "c1", "val2" => "competence", "val3" => "neg"),
            array("val0" => "Sulit untuk membuat saya marah", "val1" => "n2", "val2" => "angry hostility", "val3" => "neg"),
            array("val0" => "Saya lebih suka berlibur di tempat yang ramai seperti pantai daripada tempat yang sepi seperti hutan.", "val1" => "e2", "val2" => "gregariousness", "val3" => "pos"),
            array("val0" => "Saya begitu terpukau dengan beberapa jenis musik tertentu.", "val1" => "o2", "val2" => "aesthetic", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya memanipulasi orang lain untuk mencapai apa yang saya inginkan.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "neg"),
            array("val0" => "Saya cenderung ingin segalanya sempurna.", "val1" => "c2", "val2" => "order", "val3" => "pos"),
            array("val0" => "Saya sering memandang rendah terhadap diri saya sendiri.", "val1" => "n3", "val2" => "depression", "val3" => "pos"),
            array("val0" => "Saya lebih suka mengikuti cara saya sendiri daripada memimpin orang lain.", "val1" => "e3", "val2" => "assertiveness", "val3" => "neg"),
            array("val0" => "Saya jarang sadar akan perubahan suasana hati yang dipengaruhi oleh lingkungan yang berbeda.", "val1" => "o3", "val2" => "feelings", "val3" => "neg"),
            array("val0" => "Kebanyakan orang yang mengenal saya akan menyukai saya.", "val1" => "a3", "val2" => "altruism", "val3" => "pos"),
            array("val0" => "Saya memiliki prinsip etis yang tidak tergoyahkan.", "val1" => "c3", "val2" => "dutifulness", "val3" => "pos"),
            array("val0" => "Saya tidak terganggu oleh kehadiran atasan atau tokoh otoritas lainnya.", "val1" => "n4", "val2" => "self consciousness", "val3" => "neg"),
            array("val0" => "Saya sering terburu-buru.", "val1" => "e4", "val2" => "activity", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya melakukan perubahan di rumah hanya karena ingin mencoba yang berbeda.", "val1" => "o4", "val2" => "actions", "val3" => "pos"),
            array("val0" => "Jika seseorang memulai pertengkaran, saya siap melawannya.", "val1" => "a4", "val2" => "compliance", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk mencapai segala sesuatu yang saya inginkan.", "val1" => "c4", "val2" => "achievement striving", "val3" => "pos"),
            array("val0" => "Terkadang saya makan berlebihan sampai sakit.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "pos"),
            array("val0" => "Saya sangat menikmati roller coasters.", "val1" => "e5", "val2" => "excitement seeking", "val3" => "pos"),
            array("val0" => "Saya sangat tidak tertarik pada spekulasi mengenai sifat tata surya atau kondisi manusia sekarang.", "val1" => "o5", "val2" => "ideas", "val3" => "neg"),
            array("val0" => "Saya merasa bahwa saya tidak lebih baik dari orang lain seperti apapun keadaan mereka.", "val1" => "a5", "val2" => "modesty", "val3" => "pos"),
            array("val0" => "Ketika suatu proyek menjadi terlalu rumit, saya memutuskan untuk memulai proyek baru.", "val1" => "c5", "val2" => "self-discipline", "val3" => "neg"),
            array("val0" => "Saya dapat mengendalikan diri dengan cukup baik dalam situasi krisis.", "val1" => "n6", "val2" => "vulnerability", "val3" => "neg"),
            array("val0" => "Saya adalah orang yang ceria dan penuh semangat.", "val1" => "e6", "val2" => "positive emotions", "val3" => "pos"),
            array("val0" => "Saya merasa saya memiliki pandangan yang luas dan toleran terhadap gaya hidup orang lain.", "val1" => "o6", "val2" => "values", "val3" => "pos"),
            array("val0" => "Saya yakin semua orang pantas dihargai.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "pos"),
            array("val0" => "Saya jarang membuat keputusan secara terburu-buru.", "val1" => "c6", "val2" => "deliberation ", "val3" => "pos"),
            array("val0" => "Ketakutan saya lebih sedikit dibandingkan dengan ketakutan yang dimiliki orang lain.", "val1" => "n1", "val2" => "anxiety", "val3" => "neg"),
            array("val0" => "Saya punya hubungan emosional yang kuat dengan teman-teman saya.", "val1" => "e1", "val2" => "warmth", "val3" => "pos"),
            array("val0" => "Saat kecil, saya jarang menikmati permainan pura-pura.", "val1" => "o1", "val2" => "fantasy", "val3" => "neg"),
            array("val0" => "Saya cenderung untuk melihat sisi pos dari orang lain.", "val1" => "a1", "val2" => "trust ", "val3" => "pos"),
            array("val0" => "Saya merasa saya adalah orang yang kompeten.", "val1" => "c1", "val2" => "competence", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya merasa kesal dan penuh kebencian.", "val1" => "n2", "val2" => "angry hostility", "val3" => "pos"),
            array("val0" => "Saya merasa bosan dalam pertemuan sosial.", "val1" => "e2", "val2" => "gregariousness", "val3" => "neg"),
            array("val0" => "Terkadang saya merasa merinding atau menjadi tergerak oleh puisi yang saya baca atau karya seni yang saya lihat.", "val1" => "o2", "val2" => "aesthetic", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya menggunakan manipulasi atau rayuan untuk mencapai tujuan saya.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "neg"),
            array("val0" => "Saya tidak terlalu memperhatikan kebersihan.", "val1" => "c2", "val2" => "order", "val3" => "neg"),
            array("val0" => "Terkadang saya merasa putus asa dan tanpa harapan.", "val1" => "n3", "val2" => "depression", "val3" => "pos"),
            array("val0" => "Dalam percakapan, saya cenderung menjadi pembicara yang dominan.", "val1" => "e3", "val2" => "assertiveness", "val3" => "pos"),
            array("val0" => "Saya mudah merasa empati terhadap perasaan orang lain.", "val1" => "o3", "val2" => "feelings", "val3" => "pos"),
            array("val0" => "Saya merasa saya adalah orang yang murah hati.", "val1" => "a3", "val2" => "altruism", "val3" => "pos"),
            array("val0" => "Saya  melakukan tugas dengan hati-hati untuk menghindari harus mengulanginya.", "val1" => "c3", "val2" => "dutifulness", "val3" => "pos"),
            array("val0" => "Jika saya melakukan kesalahan pada seseorang, saya hampir tidak berani dan enggan bertemu dengan orang yang saya sakiti tersebut.", "val1" => "n4", "val2" => "self consciousness", "val3" => "pos"),
            array("val0" => "Saya memiliki ritme hidup yang cepat.", "val1" => "e4", "val2" => "activity", "val3" => "pos"),
            array("val0" => "Ketika liburan, saya lebih suka mengunjungi tempat-tempat yang sudah saya kenal.", "val1" => "o4", "val2" => "actions", "val3" => "neg"),
            array("val0" => "Saya memiliki pendirian yang kuat dan keras kepala.", "val1" => "a4", "val2" => "compliance", "val3" => "neg"),
            array("val0" => "Saya berusaha untuk melakukan yang terbaik dalam segala hal.", "val1" => "c4", "val2" => "achievement striving", "val3" => "pos"),
            array("val0" => "Kadang-kadang saya bertindak impulsif dan kemudian menyesalinya.", "val1" => "n5", "val2" => "impulsiveness", "val3" => "pos"),
            array("val0" => "Saya tertarik dengan warna-warna cerah dan gaya yang mencolok.", "val1" => "e5", "val2" => "excitement seeking", "val3" => "pos"),
            array("val0" => "Saya memiliki banyak rasa ingin tahu yang bersifat intelektual.", "val1" => "o5", "val2" => "ideas", "val3" => "pos"),
            array("val0" => "Saya lebih suka memuji orang lain daripada menerima pujian.", "val1" => "a5", "val2" => "modesty", "val3" => "pos"),
            array("val0" => "Saya sering mengabaikan pekerjaan-pekerjaan kecil yang perlu dilakukan.", "val1" => "c5", "val2" => "self-discipline", "val3" => "neg"),
            array("val0" => "Meskipun sesuatu tidak berjalan dengan baik, saya masih bisa membuat keputusan yang baik.", "val1" => "n6", "val2" => "vulnerability", "val3" => "neg"),
            array("val0" => "Saya jarang menggunakan kata-kata superlatif seperti \"menakjubkan\" atau \"hebat\" untuk menggambarkan pengalaman saya.", "val1" => "e6", "val2" => "positive emotions", "val3" => "neg"),
            array("val0" => "Saya percaya bahwa ada sesuatu yang kurang jika seseorang belum menemukan keyakinannya saat mencapai usia 25 tahun.", "val1" => "o6", "val2" => "values", "val3" => "neg"),
            array("val0" => "Saya merasa simpati terhadap orang yang kurang beruntung daripada saya.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "pos"),
            array("val0" => "Saya biasanya membuat rencana perjalanan dengan cermat sebelum bepergian.", "val1" => "c6", "val2" => "deliberation ", "val3" => "pos"),
            array("val0" => "Saya kadang-kadang dihantui oleh bayangan-bayangan menakutkan yang terlintas dalam pikiran saya.", "val1" => "n1", "val2" => "anxiety", "val3" => "pos"),
            array("val0" => "Saya memberikan perhatian pribadi kepada rekan kerja saya.", "val1" => "e1", "val2" => "warmth", "val3" => "pos"),
            array("val0" => "Saya sulit membiarkan pikiran saya mengembara tanpa kendali atau arahan", "val1" => "o1", "val2" => "fantasy", "val3" => "neg"),
            array("val0" => "Saya percaya bahwa manusia pada dasarnya baik", "val1" => "a1", "val2" => "trust ", "val3" => "pos"),
            array("val0" => "Saya bekerja dengan efisien dan efektif", "val1" => "c1", "val2" => "competence", "val3" => "pos"),
            array("val0" => "Hal kecil yang menjengkelkan bisa membuat saya frustrasi.", "val1" => "n2", "val2" => "angry hostility", "val3" => "pos"),
            array("val0" => "Saya menikmati pesta yang dihadiri banyak orang", "val1" => "e2", "val2" => "gregariousness", "val3" => "pos"),
            array("val0" => "Saya suka membaca puisi yang menekankan emosi dan imajinasi dibandingkan mengikuti suatu alur cerita .", "val1" => "o2", "val2" => "aesthetic", "val3" => "pos"),
            array("val0" => "Saya merasa bangga dengan kemampuan saya dalam menangani orang.", "val1" => "a2", "val2" => "straightforwardness", "val3" => "neg"),
            array("val0" => "Saya menghabiskan banyak waktu untuk mencari barang yang ditempatkan dengan tidak tepat.", "val1" => "c2", "val2" => "order", "val3" => "neg"),
            array("val0" => "Terkadang saya merasa putus asa dan ingin menyerah ketika sesuatu tidak berjalan sesuai rencana.", "val1" => "n3", "val2" => "depression", "val3" => "pos"),
            array("val0" => "Saya merasa sulit untuk mengendalikan situasi.", "val1" => "e3", "val2" => "assertiveness", "val3" => "neg"),
            array("val0" => "Sensasi-sensasi atau lingkungan yang tidak biasa bisa memengaruhi mood saya.", "val1" => "o3", "val2" => "feelings", "val3" => "pos"),
            array("val0" => "Saya rela berkorban sedikit demi membantu orang lain jika mampu.", "val1" => "a3", "val2" => "altruism", "val3" => "pos"),
            array("val0" => "Saya tidak masuk kerja, hanya bila saya benar-benar sakit.", "val1" => "c3", "val2" => "dutifulness", "val3" => "pos"),
            array("val0" => "Saya merasa malu jika teman saya melakukan sesuatu yang bodoh.", "val1" => "n4", "val2" => "self consciousness", "val3" => "pos"),
            array("val0" => "Saya adalah orang yang memiliki sangat banyak aktifitas", "val1" => "e4", "val2" => "activity", "val3" => "pos"),
            array("val0" => "Saya cenderung menggunakan rute yang sama ketika bepergian.", "val1" => "o4", "val2" => "actions", "val3" => "neg"),
            array("val0" => "Saya sering terlibat dalam perdebatan dengan orang-orang di sekitar saya.", "val1" => "a4", "val2" => "compliance", "val3" => "neg"),
            array("val0" => "Saya adalah orang yang 'gila kerja'.", "val1" => "c4", "val2" => "achievement striving", "val3" => "pos"),
            array("val0" => "Saya selalu dapat mengendalikan emosi saya .", "val1" => "n5", "val2" => "impulsiveness", "val3" => "neg"),
            array("val0" => "Saya suka ikut berkerumun di dalam peristiwa olahraga", "val1" => "e5", "val2" => "excitement seeking", "val3" => "pos"),
            array("val0" => "Saya memiliki minat luas dalam hal intelektual.", "val1" => "o5", "val2" => "ideas", "val3" => "pos"),
            array("val0" => "Saya pikir saya seorang 'superior'", "val1" => "a5", "val2" => "modesty", "val3" => "neg"),
            array("val0" => "Saya memiliki disiplin diri yang tinggi.", "val1" => "c5", "val2" => "self-discipline", "val3" => "pos"),
            array("val0" => "Saya cukup stabil secara emosional.", "val1" => "n6", "val2" => "vulnerability", "val3" => "neg"),
            array("val0" => "Saya mudah tertawa.", "val1" => "e6", "val2" => "positive emotions", "val3" => "pos"),
            array("val0" => "Saya percaya bahwa moralitas yang memberikan kebebasan bukanlah moralitas yang sejati.", "val1" => "o6", "val2" => "values", "val3" => "neg"),
            array("val0" => "Saya lebih suka dikenal sebagai penuh kasih daripada adil.", "val1" => "a6", "val2" => "tender-mindedness", "val3" => "pos"),
            array("val0" => "Saya berpikir panjang sebelum menjawab pertanyaan.", "val1" => "c6", "val2" => "deliberation ", "val3" => "pos")
        );

        $kode = 'part5_1';
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 5.1',
            'jenis' => 2, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 0, // Waktu default
            'menit' => 45, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ujian')->insert([
            'kode' => $kode,
            'nama' => 'Part 5.1',
            'jenis' => 2, // Sesuaikan dengan jenis yang berlaku
            'guru_id' => 2, // Sesuaikan dengan ID guru yang valid
            'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
            'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
            'jam' => 0, // Waktu default
            'menit' => 45, // Waktu default dalam menit
            'acak' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // $tespart5_1 = 'tespart5_1';
        // DB::table('ujian')->insert([
        //     'kode' => $tespart5_1,
        //     'nama' => 'Part 5.1',
        //     'jenis' => 2, // Sesuaikan dengan jenis yang berlaku
        //     'guru_id' => 1, // Sesuaikan dengan ID guru yang valid
        //     'kelas_id' => 1, // Sesuaikan dengan ID kelas yang valid
        //     'mapel_id' => 1, // Sesuaikan dengan ID mapel yang valid
        //     'jam' => 0, // Waktu default
        //     'menit' => 45, // Waktu default dalam menit
        //     'acak' => 0,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        DB::table('intruksi_ujians')->insert([
            'kode' => $kode,
            'label' => 'part 5.1.',
            'urutan' => '1',
            'intruksi' => 'PETUNJUK<br>

Bacalah semua instruksi ini dengan teliti. Persoalan berikut ini terdiri atas 240 pernyataan. Bacalah masing-masing pernyataan dengan hati-hati dan pilihlah satu jawaban yang paling tepat untuk menyatakan persetujuan Anda. Anda diminta untuk menentukan satu jawaban dari lima alternatif berikut: Sangat Tidak Setuju (STS), Tidak Setuju (TS), Netral (N), Setuju (S), dan Sangat Setuju (SS)<br>. 

Tidak ada jawaban benar atau salah. Deskripsikan diri anda secara jujur dan nyatakan pendapat anda seakurat mungkin. Anda harus menjawab semua persoalan yang ada tanpa terlewatkan. Waktu yang disediakan 45 menit.<br>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
//         DB::table('intruksi_ujians')->insert([
//             'kode' => $tespart5_1,
//             'label' => 'part 5.1.',
//             'urutan' => '1',
//             'intruksi' => 'PETUNJUK<br>

// Bacalah semua instruksi ini dengan teliti. Persoalan berikut ini terdiri atas 240 pernyataan. Bacalah masing-masing pernyataan dengan hati-hati dan pilihlah satu jawaban yang paling tepat untuk menyatakan persetujuan Anda. Anda diminta untuk menentukan satu jawaban dari lima alternatif berikut: Sangat Tidak Setuju (STS), Tidak Setuju (TS), Netral (N), Setuju (S), dan Sangat Setuju (SS)<br>. 

// Tidak ada jawaban benar atau salah. Deskripsikan diri anda secara jujur dan nyatakan pendapat anda seakurat mungkin. Anda harus menjawab semua persoalan yang ada tanpa terlewatkan. Waktu yang disediakan 45 menit.<br>',
//             'created_at' => Carbon::now(),
//             'updated_at' => Carbon::now()
//         ]);

        DB::table('relasi_ujian_merge')->insert([
            [
                'kode_ujian' => $kode,
                'kode_merge_ujian' => 'merge_ujian_1',
                'banner' => 'banner1.jpg',
                'instruksi_ujian' => 'Ikuti petunjuk dengan seksama.',
                'urutan' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'kode_ujian' => $tespart5_1,
            //     'kode_merge_ujian' => 'tes_merge_ujian_2',
            //     'banner' => 'banner2.jpg',
            //     'instruksi_ujian' => 'Pastikan koneksi stabil.',
            //     'urutan' => 8,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]
        ]);
        foreach ($kuisoner as $number => $answer) {


            $DetailKuisoner = DetailKuisoner::create([
                'kode' => $kode,
                'soal' => $answer['val0'],
                'item' => $answer['val3'],
                'jenis_jawaban_kuesioner_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DetailKuisonerFacet::create([
                'detail_kuisoner_id' => $DetailKuisoner->id,
                'kode_facet' => $answer['val1'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $counter = 0;
        foreach ($kuisoner as $number => $answer) {
            if ($counter >= 3) break;
            $counter++;

            // $DetailKuisoner = DetailKuisoner::create([
            //     'kode' => $tespart5_1,
            //     'soal' => $answer['val0'],
            //     'item' => $answer['val3'],
            //     'jenis_jawaban_kuesioner_id' => 1,
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);
            // DetailKuisonerFacet::create([
            //     'detail_kuisoner_id' => $DetailKuisoner->id,
            //     'kode_facet' => $answer['val1'],
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);
        }
    }
}
