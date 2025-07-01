<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\DetailJawabanKuesioner;
use App\Models\DetailKuisoner;
use App\Models\DetailVisual;
use App\Models\EssaySiswa;
use App\Models\KuesionerSiswa;
use App\Models\MergeUjian;
use App\Models\PgSiswa;
use App\Models\Ujian;
use App\Models\VisualSiswa;
use App\Models\WaktuUjian;
use App\Models\JawabanEssay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjianServiceController extends Controller
{
    public static function getUnscheduledExamForStudent($kodeUjian)
    {
        $waktuUjianSiswa = WaktuUjian::where('siswa_id', session()->get('id'))->pluck('kode')->toArray();

        $mergeUjian = MergeUjian::where('merge_ujian.kode', $kodeUjian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', '=', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->whereNotIn('ujian.kode', $waktuUjianSiswa) // Ambil hanya ujian yang tidak ada di waktuUjian
            ->select(
                'ujian.jenis as jenis_ujian',
                'ujian.kode as kode_ujian',
                'ujian.jam',
                'ujian.id as ujian_id',
                'ujian.menit',
                'rum.urutan'
            )
            ->orderBy('rum.urutan', 'asc')
            ->first();
        // dd($mergeUjian);
        return $mergeUjian;
    }

    public static function setEndTimeForExam($kodeUjian)
    {
        $waktuUjianSiswa = WaktuUjian::where('siswa_id', session()->get('id'))->pluck('kode')->toArray();

        $mergeUjian = MergeUjian::where('merge_ujian.kode', $kodeUjian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', '=', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->whereNotIn('ujian.kode', $waktuUjianSiswa) // Ambil hanya ujian yang tidak ada di waktuUjian
            ->select(
                'ujian.jenis as jenis_ujian',
                'ujian.kode as kode_ujian',
                'ujian.jam',
                'ujian.id as ujian_id',
                'ujian.menit',
                'rum.urutan'
            )
            ->orderBy('rum.urutan', 'asc')
            ->first(); // Ambil hanya data pertama yang ditemukan



        // Jika tidak ditemukan, tampilkan hasil debugging (opsional)
        // dd($waktuUjiantes);

        if (!$mergeUjian) {
            $mergeUjian = MergeUjian::where('merge_ujian.kode', $kodeUjian)
                ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', '=', 'merge_ujian.kode')
                ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
                ->select(
                    'ujian.jenis as jenis_ujian',
                    'ujian.kode as kode_ujian',
                    'ujian.jam',
                    'ujian.id as ujian_id',
                    'ujian.menit',
                    'rum.urutan',
                    'merge_ujian.kode as merge_ujian_kode'
                )
                ->distinct('rum.id')
                ->orderBy('rum.urutan', 'asc')
                ->first();
            // dd($mergeUjian);
        }

        $dataEndTime = [
            'waktu_berakhir' => '00-00-00'
        ];

        $waktuUjian = WaktuUjian::where('kode', $mergeUjian->kode_ujian)
            ->where('siswa_id', session()->get('id'))
            ->first();

        if ($waktuUjian) {
            // $waktuUjian->update($dataEndTime);
        } else {
            WaktuUjian::create([
                'kode' => $mergeUjian->kode_ujian,
                'siswa_id' => session()->get('id'),
                'waktu_berakhir' => "00-000-000"
            ]);
        }

        return $dataEndTime;
    }

    public static function startUJian($kodeUjian, $waktuMulaiParam)
    {
        $waktuUjian = WaktuUjian::where('kode', $kodeUjian)
            ->where('siswa_id', session()->get('id'))
            ->first();
        $ujian = Ujian::where('kode', $kodeUjian)->first();
        // $mergeUjian = ujian::where('kode',$kodeUjian)->first();
        // dd($mergeUjian);startUJian



        $hours = $ujian->jam;
        $minutes = $ujian->menit;
        $timestamp = strtotime($waktuMulaiParam);
        $endTime = date('Y-m-d H:i', strtotime("+$hours hour +$minutes minute", $timestamp));

        $dataEndTime = [
            'waktu_mulai' => date('Y-m-d H:i'),
            'waktu_berakhir' => $endTime,
            'selesai' => 0
        ];
        // dd($ujian);

        if (!$waktuUjian->waktu_mulai) {

            $waktuUjian->update($dataEndTime);
        } else {
            // $mergeUjian = MergeUjian::join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            //     ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            //     ->join('waktu_ujian', 'waktu_ujian.kode', '=', 'ujian.kode')
            //     ->where('merge_ujian.kode', $kodeMergeUjian)
            //     ->where('waktu_ujian.selesai', 1)
            //     ->where('waktu_ujian.siswa_id', session()->get('id'))
            //     ->select(
            //         'rum.*',
            //         'waktu_ujian.*',
            //         'ujian.jenis as jenis_ujian',
            //         'ujian.kode as kode_ujian',
            //         'merge_ujian.jam',
            //         'merge_ujian.menit',
            //         'merge_ujian.kode as merge_ujian_kode'
            //     )
            //     ->distinct('rum.id')
            //     ->orderBy('rum.urutan', 'asc')
            //     ->take(2) // ambil 2 data
            //     ->get();
            //         dd($mergeUjian);
            // if ($mergeUjian) {
            //     if ($mergeUjian[0]->kode_ujian != $kodeUjian) {
            //         dd($mergeUjian[0]);
            //     }
            // }
        }

        $ujian = Ujian::where('kode', $kodeUjian)->first();
        // dd($ujian);

        if ($ujian->jenis == '3') {
            $visual_siswa = VisualSiswa::where('kode', $kodeUjian)
                ->where('siswa_id', session()->get('id'))
                ->count();
            if ($visual_siswa == 0) {
                $detailVisual = DetailVisual::where('kode', $kodeUjian)->get();
                foreach ($detailVisual as $key => $value) {
                    VisualSiswa::create([
                        'siswa_id' => session()->get('id'),
                        'detail_visual_id' => $value->id,
                        'kode' => $kodeUjian,
                    ]);
                }
            }
            // dd($visual_siswa);
        }
        return $dataEndTime;
    }

    public static function createOrRetrievePgSiswa($kode_ujian)
    {
        // Retrieve existing records of PgSiswa for the specific exam and student
        $ujian = Ujian::where('kode', $kode_ujian)->first();
        $pg_siswa = PgSiswa::where('kode', $ujian->kode)
            ->where('siswa_id', session()->get('id'))
            ->get();

        // If no records found, prepare data for insertion
        if ($pg_siswa->count() == 0) {
            $data_pg_siswa = [];

            // Populate data_pg_siswa with details from each exam question
            foreach ($ujian->detailujian as $soal) {
                array_push($data_pg_siswa, [
                    'detail_ujian_id' => $soal->id,
                    'kode' => $soal->kode,
                    'siswa_id' => session()->get('id')
                ]);
            }

            // Shuffle questions if the exam setting requires it
            if ($ujian->acak == 1) {
                $randomize = collect($data_pg_siswa)->shuffle();
                $soal_pg_siswa = $randomize->toArray();
            } else {
                $soal_pg_siswa = $data_pg_siswa;
            }

            // Insert shuffled or ordered questions into PgSiswa table
            PgSiswa::insert($soal_pg_siswa);
        }

        return $ujian;
    }
    
    public static function createOrRetrieveVisualSiswa($kode_ujian)
    {
        // Retrieve existing records of PgSiswa for the specific exam and student
        $ujian = Ujian::where('kode', $kode_ujian)->first();
        $detailUjian = DetailVisual::where('kode', $kode_ujian)->get();
        // dd($detailUjian);
        $visual_siswa = VisualSiswa::where('kode', $ujian->kode)
            ->where('siswa_id', session()->get('id'))
            ->get();

        // If no records found, prepare data for insertion
        if ($visual_siswa->count() == 0) {
            $data_visual_siswa = [];

            // Populate data_visual_siswa with details from each exam question
            foreach ($detailUjian as $soal) {
                array_push($data_visual_siswa, [
                    'detail_visual_id' => $soal->id,
                    'kode' => $soal->kode,
                    'siswa_id' => session()->get('id')
                ]);
            }

            // Shuffle questions if the exam setting requires it
            if ($ujian->acak == 1) {
                $randomize = collect($data_visual_siswa)->shuffle();
                $soal_visual_siswa = $randomize->toArray();
            } else {
                $soal_visual_siswa = $data_visual_siswa;
            }

            // Insert shuffled or ordered questions into VisualSiswa table
            VisualSiswa::insert($soal_visual_siswa);
        }

        return $ujian;
    }
    public static function createOrRetrieveKuesionerSiswa($kode_ujian)
    {
        // Retrieve existing records of PgSiswa for the specific exam and student
        $ujian = Ujian::where('kode', $kode_ujian)->first();
        // dd($kode_ujian);
        $detailKuisoner = DetailKuisoner::where('kode', $kode_ujian)->get();
        $kuesioner_siswa = KuesionerSiswa::where('kode', $ujian->kode)
            ->where('siswa_id', session()->get('id'))
            ->get();
        // dd($detailKuisoner);

        // If no records found, prepare data for insertion
        if ($kuesioner_siswa->count() == 0) {
            $data_kuesioner_siswa = [];

            // Populate data_kuesioner_siswa with details from each exam question
            foreach ($detailKuisoner as $kuixoner) {
                array_push($data_kuesioner_siswa, [
                    'siswa_id' => session()->get('id'),
                    'kode' => $kuixoner->kode,
                    'jenis_jawaban_kuesioner_id' => $kuixoner->jenis_jawaban_kuesioner_id,
                    'detail_kuisoner' => $kuixoner->id,
                ]);
            }

            // Shuffle questions if the exam setting requires it
            if ($ujian->acak == 1) {
                $randomize = collect($data_kuesioner_siswa)->shuffle();
                $soal_kuesioner_siswa = $randomize->toArray();
            } else {
                $soal_kuesioner_siswa = $data_kuesioner_siswa;
            }

            // Insert shuffled or ordered questions into VisualSiswa table
            KuesionerSiswa::insert($soal_kuesioner_siswa);
        }

        return $ujian;
    }

    public static function pilihan_ganda_siswa($kode, $id)
    {
        $ujian = Ujian::where('kode', $kode)->first();

        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs

        // Get total number of questions for the current ujian
        $total_soal_pg = $ujian->detailujian->count();

        $pgUjian = PgSiswa::join('detail_ujian as du', 'du.id', '=', 'pg_siswa.detail_ujian_id')
            ->join('siswa', 'siswa.id', '=', 'pg_siswa.siswa_id')
            ->where('du.kode', $ujian->kode)
            ->where('siswa.id', $id)
            ->select(
                'siswa.id as siswa_id', // Include siswa ID for tracking duplicates
                'siswa.nama_siswa as siswa_nama',
                DB::raw("SUM(CASE WHEN UPPER(pg_siswa.jawaban) = UPPER(du.jawaban) THEN 1 ELSE 0 END) as jumlah_benar"),
                DB::raw("SUM(CASE WHEN UPPER(pg_siswa.jawaban) != UPPER(du.jawaban) THEN 1 ELSE 0 END) as jumlah_salah"),
                DB::raw("SUM(CASE WHEN pg_siswa.jawaban IS NULL OR pg_siswa.jawaban = '' THEN 1 ELSE 0 END) as jumlah_tidak_jawab") // Count unanswered questions
            )
            ->groupBy('siswa.id', 'siswa.nama_siswa')
            ->get();

        foreach ($pgUjian as $value) {
            // Check if this student has already been processed
            if (!in_array($value->siswa_id, $processedSiswaIds)) {
                $jumlah_benar = $value->jumlah_benar;
                // Calculate the score
                $nilai = ($jumlah_benar / $total_soal_pg) * 100;

                // Store each student's results in the array
                $results[] = [
                    'siswa_nama' => $value->siswa_nama,
                    'jumlah_benar' => $jumlah_benar,
                    'jumlah_salah' => $value->jumlah_salah,
                    'jumlah_tidak_jawab' => $value->jumlah_tidak_jawab, // Add unanswered questions count
                    'nilai' => $nilai
                ];

                // Mark this student ID as processed
                $processedSiswaIds[] = $value->siswa_id;
            }
        }

        return  $results;
    }


    public static function pilihan_kusoner_siswa($kode, $id)
    {
        $ujian = Ujian::where('kode', $kode)->first();
        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs
        //  dd($ujian);

        // Step 1: Fetch distinct codes from detail_jawaban_kuesioner
        $distinctCodes = DetailJawabanKuesioner::select('kode')->distinct()->pluck('kode');

        // Step 2: Construct the select statements dynamically
        $selectStatements = [
            'siswa.id as siswa_id',
            'siswa.nama_siswa as siswa_nama',
            'kuesioner_siswa.kode as kode_ujian',
            'kuesioner_siswa.jenis_jawaban_kuesioner_id as jenis_jawaban_kuesioner_id',
            DB::raw('COUNT(detail_jawaban_kuesioner.id) as jumlah_terkait'),
            DB::raw('GROUP_CONCAT(detail_jawaban_kuesioner.kode) as terkait_kode')
        ];

        // Loop through each distinct code to create dynamic count statements
        foreach ($distinctCodes as $code) {
            $selectStatements[] = DB::raw("SUM(CASE WHEN detail_jawaban_kuesioner.kode = '{$code}' THEN 1 ELSE 0 END) as count_{$code}");
        }

        // Step 3: Execute the main query
        $pgUjian = KuesionerSiswa::join('detail_kuisoner as dk', 'dk.id', '=', 'kuesioner_siswa.detail_kuisoner')
            ->join('siswa', 'siswa.id', '=', 'kuesioner_siswa.siswa_id')
            ->leftJoin('jenis_jawaban_kuesioner', 'jenis_jawaban_kuesioner.id', '=', 'kuesioner_siswa.jenis_jawaban_kuesioner_id')
            ->leftJoin('detail_jawaban_kuesioner', 'detail_jawaban_kuesioner.id', '=', 'kuesioner_siswa.detail_jawaban_kuesioner_id')
            ->where('kuesioner_siswa.kode', $ujian->kode)
            ->where('siswa.id', $id)
            ->select($selectStatements)
            ->groupBy('siswa.id', 'siswa.nama_siswa', 'kuesioner_siswa.kode', 'kuesioner_siswa.jenis_jawaban_kuesioner_id')
            ->get();

        // Display the results
        // dd($pgUjian);        



        // Output the results to check each student's total score
        // foreach ($pgUjian as $value) {
        //     echo "Siswa: " . $value->siswa_nama . "<br/>";
        //     echo "Kode Ujian: " . $value->kode_ujian . "<br/>";
        //     echo "Total Nilai: " . $value->total_nilai . "<br/><br/>";
        // }
        // dd($pgUjian);
        foreach ($pgUjian as $value) {
            $DetailJawanKuisunoer = DetailJawabanKuesioner::where('jenis_jawaban_kuesioner_id', $value->jenis_jawaban_kuesioner_id)->get();
            $data_kuesioner_siswa = [];

            // Populate data_kuesioner_siswa with details from each exam question
            foreach ($DetailJawanKuisunoer as $kuixoner) {
                if ($value->{'count_' . $kuixoner->kode}) {
                    array_push($data_kuesioner_siswa, [
                        'kode' => $kuixoner->kode,
                        'jenis_jawaban_kuesioner_id' => $kuixoner->jenis_jawaban_kuesioner_id,
                        'detail_kuisoner' => $kuixoner->id,
                        'count' => $value->{'count_' . $kuixoner->kode},
                    ]);
                }
            }

            // Check if this student has already been processed
            if (!in_array($value->siswa_id, $processedSiswaIds)) {


                // Store each student's results in the array
                $results[] = [
                    'siswa_nama' => $value->siswa_nama,
                    'jenis_jawaban_kuesioner_id' => $value->jenis_jawaban_kuesioner_id,
                    'siswa_id' => $value->siswa_id,
                    'kode_ujian' => $value->kode_ujian,
                    'total_nilai' => $value->total_nilai,
                    'jumlah_dijawab' => $value->jumlah_dijawab,
                    'jumlah_tidak_dijawab' => $value->jumlah_tidak_dijawab,
                    'detail_Kuisunoer' => $data_kuesioner_siswa,
                ];

                // Mark this student ID as processed
                $processedSiswaIds[] = $value->siswa_id;
            }
        }

        return  $results;
    }

    public static function pilihan_esay_siswa($kode, $id)
    {
        $ujian = Ujian::where('kode', $kode)->first();
        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs


        $pgUjian = EssaySiswa::join('detail_essay as du', 'du.id', '=', 'essay_siswa.detail_ujian_id')
            ->join('siswa', 'siswa.id', '=', 'essay_siswa.siswa_id')
            ->where('essay_siswa.kode', $ujian->kode)
            ->where('siswa.id', $id)
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama_siswa as siswa_nama',
                'essay_siswa.kode as kode_ujian',
                DB::raw("SUM(essay_siswa.nilai) as total_nilai"), // Sum of nilai
                DB::raw("COUNT(essay_siswa.nilai) as jumlah_dijawab"), // Count of answered questions
                DB::raw("COUNT(*) - COUNT(essay_siswa.nilai) as jumlah_tidak_dijawab") // Total questions - answered questions
            )
            ->groupBy('siswa.id', 'siswa.nama_siswa', 'essay_siswa.kode')
            ->get();

        // Output the results to check each student's total score
        // foreach ($pgUjian as $value) {
        //     echo "Siswa: " . $value->siswa_nama . "<br/>";
        //     echo "Kode Ujian: " . $value->kode_ujian . "<br/>";
        //     echo "Total Nilai: " . $value->total_nilai . "<br/><br/>";
        // }
        // dd($pgUjian);
        foreach ($pgUjian as $value) {
            // Check if this student has already been processed
            if (!in_array($value->siswa_id, $processedSiswaIds)) {

                $total_nilai = 0;
                $essayAnswers = EssaySiswa::where('kode', $value->kode_ujian)
                    ->where('siswa_id', $value->siswa_id)
                    ->get();

                foreach ($essayAnswers as $answer) {
                    $jawabanEssay = JawabanEssay::where('detail_essay_id', $answer->detail_ujian_id)->get();
                    foreach ($jawabanEssay as $jawaban) {
                        if (strpos($answer->jawaban, $jawaban->jawaban) !== false) {
                            $total_nilai += $jawaban->nilai;
                        }
                    }
                }
                // Store each student's results in the array
                $results[] = [
                    'siswa_nama' => $value->siswa_nama,
                    'siswa_id' => $value->siswa_id,
                    'kode_ujian' => $value->kode_ujian,
                    'total_nilai' => $total_nilai + $value->total_nilai,
                    'jumlah_dijawab' => $value->jumlah_dijawab,
                    'jumlah_tidak_dijawab' => $value->jumlah_tidak_dijawab,
                ];

                // Mark this student ID as processed
                $processedSiswaIds[] = $value->siswa_id;
            }
        }

        // dd($results);
        return  $results;
    }

    public static function pilihan_visual_siswa($kode, $id)
    {
        $ujian = Ujian::where('kode', $kode)->first();


        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs

        foreach ($ujian->detailVisual as $key => $detailVisual) {
        }
        // Get total number of questions for the current ujian
        $total_soal_pg = $ujian->detailVisual->count();

        $visualUjian = VisualSiswa::join('detail_visual as dv', 'dv.id', '=', 'visual_siswa.detail_visual_id')
            ->join('siswa', 'siswa.id', '=', 'visual_siswa.siswa_id')
            ->where('dv.kode', $ujian->kode)
            ->where('siswa.id', $id)
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama_siswa as siswa_nama',
                DB::raw("SUM(
            CASE 
                WHEN (UPPER(SUBSTR(visual_siswa.jawaban_1, 14, 1)) = UPPER(dv.jawaban_1) OR UPPER(SUBSTR(visual_siswa.jawaban_1, 14, 1)) = UPPER(dv.jawaban_2))
                AND (UPPER(SUBSTR(visual_siswa.jawaban_2, 14, 1)) = UPPER(dv.jawaban_1) OR UPPER(SUBSTR(visual_siswa.jawaban_2, 14, 1)) = UPPER(dv.jawaban_2))
                THEN 1 
                ELSE 0 
            END
        ) as jumlah_benar"),
                DB::raw("SUM(
            CASE 
                WHEN (SUBSTR(visual_siswa.jawaban_1, 14, 1) IS NOT NULL AND SUBSTR(visual_siswa.jawaban_1, 14, 1) != '' AND
                     (UPPER(SUBSTR(visual_siswa.jawaban_1, 14, 1)) != UPPER(dv.jawaban_1) AND UPPER(SUBSTR(visual_siswa.jawaban_1, 14, 1)) != UPPER(dv.jawaban_2)))
                OR (SUBSTR(visual_siswa.jawaban_2, 14, 1) IS NOT NULL AND SUBSTR(visual_siswa.jawaban_2, 14, 1) != '' AND
                     (UPPER(SUBSTR(visual_siswa.jawaban_2, 14, 1)) != UPPER(dv.jawaban_1) AND UPPER(SUBSTR(visual_siswa.jawaban_2, 14, 1)) != UPPER(dv.jawaban_2)))
                THEN 1 
                ELSE 0 
            END
        ) as jumlah_salah"),
                DB::raw("SUM(
            CASE 
                WHEN (visual_siswa.jawaban_1 IS NULL OR visual_siswa.jawaban_1 = '') 
                OR (SUBSTR(visual_siswa.jawaban_2, 14, 1) IS NULL OR SUBSTR(visual_siswa.jawaban_2, 14, 1) = '') 
                THEN 1 
                ELSE 0 
            END
        ) as jumlah_tidak_jawab")
            )
            ->groupBy('siswa.id', 'siswa.nama_siswa')
            ->get();

        // dd($visualUjian);
        foreach ($visualUjian as $value) {
            // Check if this student has already been processed
            if (!in_array($value->siswa_id, $processedSiswaIds)) {
                $jumlah_benar = $value->jumlah_benar;
                // Calculate the score
                $nilai = ($jumlah_benar / $total_soal_pg) * 100;

                // Store each student's results in the array
                $results[] = [
                    'siswa_nama' => $value->siswa_nama,
                    'jumlah_benar' => $jumlah_benar,
                    'jumlah_salah' => $value->jumlah_salah,
                    'jumlah_tidak_jawab' => $value->jumlah_tidak_jawab, // Add unanswered questions count
                    'nilai' => $nilai
                ];

                // Mark this student ID as processed
                $processedSiswaIds[] = $value->siswa_id;
            }
        }
        // Now $results contains unique entries for each student
        // dd($results); // Output the array to check the final result





        // dd($ujian);

        // return false;
        return  $results;
    }
}
