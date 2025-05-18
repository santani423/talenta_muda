<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiIq;
use App\Models\SkorKalender;
use Illuminate\Http\Request;


class PenilaianController extends Controller
{
    public function Kuisoner($jawaba, $detail_kuisoner_id, $item)
    {
        return view('service.penilaian.kuisoner', compact('detail_kuisoner'));
    }



    public function prosesSkorKalender($core = 28, $umurTahun = 20, $umurBulan = 6)
    {


        // Gabungkan tahun dan bulan menjadi desimal
        $umurGabungan = $umurTahun + ($umurBulan / 12);

        // Cari skor kalender yang sesuai umur dan core
        $kalenderScore = SkorKalender::where('total_raw_score', $core)
            ->whereRaw('(CONVERT(usia_dari_tahun, UNSIGNED) + CONVERT(usia_dari_bulan, UNSIGNED)/12) <= ?', [$umurGabungan])
            ->whereRaw('(CONVERT(usia_sampai_tahun, UNSIGNED) + CONVERT(usia_sampai_bulan, UNSIGNED)/12) >= ?', [$umurGabungan])
            ->first();

        // Ambil nilai IQ dari hasil skor kalender
        $nilaiIQ = $kalenderScore->nilai ?? 0;

        // Cari klasifikasi berdasarkan nilai IQ
        $klasifikasi = KlasifikasiIq::where('iq_min', '<=', $nilaiIQ)
            ->where(function ($query) use ($nilaiIQ) {
                $query->where('iq_max', '>=', $nilaiIQ)
                    ->orWhereNull('iq_max');
            })
            ->first();

        // Kembalikan response JSON
        return ([
            'core' => $core,
            'umur_tahun' => $umurTahun,
            'umur_bulan' => $umurBulan,
            'umur_gabungan' => round($umurGabungan, 2),
            'nilaiIQ' => $nilaiIQ,
            'klasifikasi' => $klasifikasi,
            'kalenderScore' => $kalenderScore,
        ]);
    }
}
