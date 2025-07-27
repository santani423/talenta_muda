<?php

namespace App\Http\Controllers;

use App\Models\KlasifikasiIq;
use App\Models\SkorKalender;
use App\Models\TScore;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        try {
            $core = $request->input('nilai', 28); // Nilai core/total_raw_score
            $tanggalLahir = $request->input('tanggal_lahir','1998-04-30'); // Format: YYYY-MM-DD

            // Validasi input tanggal lahir
            if (!$tanggalLahir) {
                return response()->json(['error' => 'Tanggal lahir diperlukan'], 400);
            }

            // Hitung umur dari tanggal lahir sampai hari ini
            $birthDate = Carbon::parse($tanggalLahir);
            $today = Carbon::now();
            $umurTahun = $today->diffInYears($birthDate);
            $umurBulan = $today->diffInMonths($birthDate) % 12;

            // Gabungkan tahun dan bulan menjadi angka desimal (misal: 20.6)
            $umurGabungan = $umurTahun + ($umurBulan / 12);

            // Ambil skor kalender berdasarkan core dan rentang umur
            $kalenderScore = SkorKalender::where('total_raw_score', $core)
                ->whereRaw('(CONVERT(usia_dari_tahun, UNSIGNED) + CONVERT(usia_dari_bulan, UNSIGNED)/12) <= ?', [$umurGabungan])
                ->whereRaw('(CONVERT(usia_sampai_tahun, UNSIGNED) + CONVERT(usia_sampai_bulan, UNSIGNED)/12) >= ?', [$umurGabungan])
                ->first();

            // Ambil nilai IQ
            $nilaiIQ = $kalenderScore->nilai ?? 0;

            // Cari klasifikasi IQ
            $klasifikasi = KlasifikasiIq::where('iq_min', '<=', $nilaiIQ)
                ->where(function ($query) use ($nilaiIQ) {
                    $query->where('iq_max', '>=', $nilaiIQ)
                        ->orWhereNull('iq_max');
                })
                ->first();

            // Kembalikan hasil
            return response()->json([
                'core' => $core,
                'tanggal_lahir' => $tanggalLahir,
                'umur_tahun' => $umurTahun,
                'umur_bulan' => $umurBulan,
                'umur_gabungan' => round($umurGabungan, 2),
                'kalenderScore' => $kalenderScore,
                'nilaiIQ' => $nilaiIQ,
                'klasifikasi' => $klasifikasi,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TScore $tScore)
    {
        return view('tespirnt');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TScore $tScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TScore $tScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TScore $tScore)
    {
        //
    }
}
