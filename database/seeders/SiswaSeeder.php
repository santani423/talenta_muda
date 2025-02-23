<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('siswa')->insert([
            [
                'nis' => '12345678',
                'nama_siswa' => 'Ahmad Fauzi',
                'gender' => 'Laki-laki',
                'kelas_id' => 1,
                'email' => 'ahmad.fauzi@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2005-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '12345679',
                'nama_siswa' => 'Siti Aminah',
                'gender' => 'Perempuan',
                'kelas_id' => 1,
                'email' => 'siti.aminah@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2004-09-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '12345680',
                'nama_siswa' => 'Budi Santoso',
                'gender' => 'Laki-laki',
                'kelas_id' => 1,
                'email' => 'budi.santoso@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2005-05-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $siswa = Siswa::all();
        $part1_1 = DB::table('detail_ujian')->where('kode', 'part1_1')->get();
        $part1_2 = DB::table('detail_visual')->where('kode', 'part1_2')->get();
        $part1_3 = DB::table('detail_ujian')->where('kode', 'part1_3')->get();
        $part1_4 = DB::table('detail_ujian')->where('kode', 'part1_4')->get();
        $part2 = DB::table('detail_ujian')->where('kode', 'part2')->get();
        $part3 = DB::table('detail_essay')->where('kode', 'part3')->get();
        $part4 = DB::table('detail_essay')->where('kode', 'part4')->get();
        $part5_1 = DB::table('detail_kuisoner')->where('kode', 'part5_1')->get();
        $part5_2 = DB::table('detail_kuisoner')->where('kode', 'part5_2')->get();
        $part5_3 = DB::table('detail_kuisoner')->where('kode', 'part5_3')->get();
        foreach ($siswa as $s) {

            foreach ($part1_1 as $du) {
                $jawaban = chr(rand(97, 102)); // Generate random answer from 'a' to 'f'
                // $nilai = $jawaban == $du->jawaban ? 1 : 0; // Assign nilai based on correctness of the answer
                $nilai = $jawaban == 'c'? 1 : 0; // Assign nilai based on correctness of the answer
                DB::table('pg_siswa')->insert([
                    'detail_ujian_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban' => $jawaban,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($part1_2 as $du) {
                $jawaban1 = chr(rand(97, 102)); // Generate random answer from 'a' to 'f'
                $jawaban2 = chr(rand(97, 102)); // Generate random answer from 'a' to 'f'
                $nilai = rand(4, 6); // Generate random nilai from 1 to 10
                if ($nilai >= 2 && $nilai <= 5) {
                    $jawaban1 = $du->jawaban_1;
                    $jawaban2 = $du->jawaban_2;
                }
                $nilai = ( $jawaban1 ==  $du->jawaban_1) && ( $jawaban2 ==  $du->jawaban_2)? 1 : 0;
                DB::table('visual_siswa')->insert([
                    'detail_visual_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban_1' =>  $jawaban1,
                    'jawaban_2' =>  $jawaban2,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($part1_3 as $du) {
                $jawaban = chr(rand(97, 102)); // Generate random answer from 'a' to 'f'
                $nilai = $jawaban == $du->jawaban ? 1 : 0; // Assign nilai based on correctness of the answer
                DB::table('pg_siswa')->insert([
                    'detail_ujian_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban' => $jawaban,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($part1_4 as $du) {
                $jawaban = chr(rand(97, 102)); // Generate random answer from 'a' to 'f'
                $nilai = $jawaban == $du->jawaban ? 1 : 0; // Assign nilai based on correctness of the answer
                DB::table('pg_siswa')->insert([
                    'detail_ujian_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban' => $jawaban,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($part2 as $du) {
                $jawaban = chr(rand(97, 102)); // Generate random answer from 'a' to 'f'
                $nilai = $jawaban == $du->jawaban ? 1 : 0; // Assign nilai based on correctness of the answer
                DB::table('pg_siswa')->insert([
                    'detail_ujian_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban' => $jawaban,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($part3 as $du) {
                $jawaban = rand(1, 100);  
                $nilai = 0;
            
                $kunci_jawaban = DB::table('jawaban_essays')->where('detail_essay_id', $du->id)->get();
                
                if ($kunci_jawaban->isNotEmpty()) {
                    foreach ($kunci_jawaban as $key => $value) {
                        // Gunakan probabilitas 30-50% untuk menentukan apakah jawaban benar
                        $isCorrect = rand(1, 100) <= rand(30, 50);
            
                        if ($isCorrect) {
                            $jawaban = (int) $value->jawaban; // Set jawaban menjadi benar
                            $nilai = 1; // Berikan nilai 1
                            break; // Keluar dari loop karena sudah dapat jawaban benar
                        }
                    }
                }
            
                DB::table('essay_siswa')->insert([
                    'detail_ujian_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban' => $jawaban,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            foreach ($part4 as $du) {
                $jawaban = rand(1, 10000000);  
                $nilai = 0;
                $kunci_jawaban = DB::table('jawaban_essays')->where('detail_essay_id', $du->id)->get();
                if ($kunci_jawaban) {
                    foreach ($kunci_jawaban as $key => $value) {
                        $isCorrect = rand(1, 100) <= rand(30, 50);
                        if ($isCorrect) {
                            $jawaban =  $value->jawaban; // Set jawaban menjadi benar
                            $nilai = $value->nilai; // Berikan nilai 1
                            break; // Keluar dari loop karena sudah dapat jawaban benar
                        }
                    }
                }
                  DB::table('essay_siswa')->insert([
                    'detail_ujian_id' => $du->id,
                    'kode' => $du->kode,
                    'siswa_id' => $s->id,
                    'jawaban' => $jawaban,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            foreach ($part5_1 as $du) {
                $jawaban = rand(1, 5);
                
                DB::table('kuesioner_siswa')->insert([
                    'siswa_id' => $s->id,
                    'kode' => $du->kode,
                    'detail_kuisoner' => $du->id,
                    'jenis_jawaban_kuesioner_id' => 1,
                    'detail_jawaban_kuesioner_id' => $jawaban, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            foreach ($part5_2 as $du) {
                $jawaban = rand(1, 5);
                
                DB::table('kuesioner_siswa')->insert([
                    'siswa_id' => $s->id,
                    'kode' => $du->kode,
                    'detail_kuisoner' => $du->id,
                    'jenis_jawaban_kuesioner_id' => 2,
                    'detail_jawaban_kuesioner_id' => $jawaban, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            foreach ($part5_3 as $du) {
                $jawaban = rand(6, 7);
                
                DB::table('kuesioner_siswa')->insert([
                    'siswa_id' => $s->id,
                    'kode' => 'part5_3',
                    'detail_kuisoner' => $du->id,
                    'jenis_jawaban_kuesioner_id' => 2,
                    'detail_jawaban_kuesioner_id' => $jawaban, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } 
        }

        DB::table('siswa')->insert([
            [
                'nis' => '12345681',
                'nama_siswa' => 'Ani Susanti',
                'gender' => 'Perempuan',
                'kelas_id' => 2,
                'email' => 'ani.susanti@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2005-03-12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '12345682',
                'nama_siswa' => 'Dewi Anggraini',
                'gender' => 'Perempuan',
                'kelas_id' => 2,
                'email' => 'dewi.anggraini@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2004-11-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '12345683',
                'nama_siswa' => 'Eko Prasetyo',
                'gender' => 'Laki-laki',
                'kelas_id' => 3,
                'email' => 'eko.prasetyo@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2005-08-07',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '12345684',
                'nama_siswa' => 'Faisal Rahman',
                'gender' => 'Laki-laki',
                'kelas_id' => 3,
                'email' => 'faisal.rahman@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2005-06-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '12345685',
                'nama_siswa' => 'Citra Lestari',
                'gender' => 'Perempuan',
                'kelas_id' => 4,
                'email' => 'citra.lestari@example.com',
                'password' => bcrypt('password123'),
                'avatar' => 'default_avatar.png',
                'role' => 3,
                'is_active' => 1,
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2004-12-19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

       

        Siswa::create([
            'nis' => '12345687',
            'nama_siswa' => 'Gilang Ramadhan',
            'gender' => 'Laki-laki',
            'kelas_id' => 1,
            'email' => 'gilang.ramadhan@example.com',
            'password' => bcrypt('password123'),
            'avatar' => 'default_avatar.png',
            'role' => 3,
            'is_active' => 1,
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-02-14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Siswa::create([
            'nis' => '12345688',
            'nama_siswa' => 'Hana Pratiwi',
            'gender' => 'Perempuan',
            'kelas_id' => 1,
            'email' => 'hana.pratiwi@example.com',
            'password' => bcrypt('password123'),
            'avatar' => 'default_avatar.png',
            'role' => 3,
            'is_active' => 1,
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2005-07-21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Siswa::create([
            'nis' => '12345689',
            'nama_siswa' => 'Indra Wijaya',
            'gender' => 'Laki-laki',
            'kelas_id' => 1,
            'email' => 'indra.wijaya@example.com',
            'password' => bcrypt('password123'),
            'avatar' => 'default_avatar.png',
            'role' => 3,
            'is_active' => 1,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2005-11-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
