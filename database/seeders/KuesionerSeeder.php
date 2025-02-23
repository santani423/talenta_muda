<?php

namespace Database\Seeders;

use App\Models\DetailJawabanKuesioner;
use App\Models\JenisJawabanKuesioner;
use Illuminate\Database\Seeder;

class KuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inserting data into JenisJawabanKuesioner
        $jenisJawabanKuesioner1 = JenisJawabanKuesioner::create([
            'kode' => 'JK001',
            'nama_kuesioner' => '5 Pilihan',
        ]);

        $jenisJawabanKuesioner2 = JenisJawabanKuesioner::create([
            'kode' => 'JK002',
            'nama_kuesioner' => '2 Pilihan',
        ]);

        // Inserting data into DetailJawabanKuesioner
        DetailJawabanKuesioner::create([
            'kode' => 'STS',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner1->id,
            'pilihan_kuesioner' => 'Sangat Tidak Setuju',
        ]);

        DetailJawabanKuesioner::create([
            'kode' => 'TS',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner1->id,
            'pilihan_kuesioner' => 'Tidak Setuju',
        ]);

        DetailJawabanKuesioner::create([
            'kode' => 'N',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner1->id,
            'pilihan_kuesioner' => 'Netral',
        ]);

        DetailJawabanKuesioner::create([
            'kode' => 'S',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner1->id,
            'pilihan_kuesioner' => 'Setuju',
        ]);

        DetailJawabanKuesioner::create([
            'kode' => 'SS',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner1->id,
            'pilihan_kuesioner' => 'Sangat Setuju',
        ]);

        DetailJawabanKuesioner::create([
            'kode' => 'B',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner2->id,
            'pilihan_kuesioner' => 'Benar',
        ]);

        DetailJawabanKuesioner::create([
            'kode' => 'S',
            'jenis_jawaban_kuesioner_id' => $jenisJawabanKuesioner2->id,
            'pilihan_kuesioner' => 'Salah',
        ]);
    }
}
