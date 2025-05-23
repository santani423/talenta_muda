<?php

namespace App\Http\Controllers;

use App\Models\DetailKuisoner;
use App\Models\DetailKuisonerSekala;
use App\Models\Domain;
use App\Models\EssaySiswa;
use App\Models\Facet;
use App\Models\IntruksiUjian;
use App\Models\JawabanEssay;
use App\Models\KuesionerSiswa;
use App\Models\PgSiswa;
use App\Models\Sekala;
use App\Models\Ujian;
use App\Models\VisualSiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PenilaianSiswaController extends Controller
{
    public function hasil_ujian($id, $kode)
    {
        $pg = PgSiswa::where('siswa_id', $id)->where('kode', $kode)->get();
        return view('penilaian_siswa.hasil_ujian', compact('pg'));
    }

    public function ujan_pg($id, $kode)
    {
        try {

            $pg = PgSiswa::where('siswa_id', $id)->where('kode', $kode)->get();
            foreach ($pg as $key => $value) {
                if (!$value->nilai || $value->nilai == 0 || $value->nilai == null) {
                    if (strtolower($value->jawaban) == strtolower($value->detailujian->jawaban)) {
                        $value->nilai = 1;
                        $value->save();
                    } else {
                        $value->nilai = 0;
                        $value->save();
                    }
                }
            }
            $pg = PgSiswa::where('siswa_id', $id)->where('kode', $kode)->get();
            // dd($pg);
            $response = [
                'status' => 'success',
                'data' => $pg,
                'message' => 'Data retrieved successfully',
                'code' => 200
            ];
            $status = 200;
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'code' => 500
            ];
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function ujan_kuisoner($id, $kode)
    {

        $kuisoners = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->rightJoin('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->leftJoin('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->where('kuesioner_siswa.kode', $kode)
            ->select(
                'kuesioner_siswa.*',
                'detail_jawaban_kuesioner.kode as jawaban',
                'detail_kuisoner.item as kuisoner_item',
                'detail_jawaban_kuesioner.pilihan_kuesioner'
            )
            ->get();



        $totalNilai = 0;
        $skorNilai = false;
        $kuisonersBenarSalah = [];
        foreach ($kuisoners as $kuisonersBenarSalah) {
            // dd($kuisonersBenarSalah->detailKuisoner[0]->jawaban);
            // dd($kuisonersBenarSalah->jawaban);
            if (str_replace(' ', '', $kuisonersBenarSalah->jawaban) == str_replace(' ', '', $kuisonersBenarSalah->detailKuisoner[0]->jawaban)) {
                $kuisonersBenarSalah->nilai = 1;
                // dd($kuisonersBenarSalah);
            } else {
                $kuisonersBenarSalah->nilai = 0;
            }
            if ($kuisonersBenarSalah->detailKuisoner[0]->jawaban != null && $kuisonersBenarSalah->detailKuisoner[0]->jawaban != '') {
                # code...
                $skorNilai = true;
            }
            $totalNilai += $kuisonersBenarSalah->nilai;
        }


        $facet = $this->facet($id, $kode);
        $sekala = $this->sekala($id, $kode);
        // dd($sekala);

        try {
            $kuisonerItem = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
                ->rightJoin('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
                ->leftJoin('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
                ->where('kuesioner_siswa.kode', $kode)
                ->select('kuesioner_siswa.*', 'detail_jawaban_kuesioner.kode as jawaban', 'detail_kuisoner.jenis_jawaban_kuesioner_id as jenis_jawaban_kuesioner_id')
                ->get()
                ->chunk(20)
                ->toArray();
            $ujian = Ujian::where('ujian.kode', $kode)
                ->leftJoin('detail_kuisoner', 'detail_kuisoner.kode', '=', 'ujian.kode')
                ->first();
            $response = [
                'status' => 'success',
                'data' => [
                    'ujian' => $ujian,
                    'kuisoner' => $kuisonerItem,
                    'sekala' => $sekala,
                    'facet' => $facet,
                    'skorNilai' => $skorNilai,
                    'kuisonersBenarSalah' => [
                        'totalNilai' => $totalNilai,
                        'kuisoner' =>  $kuisonersBenarSalah,
                    ],
                ],
                'message' => 'Data retrieved successfully',
                'code' => 200
            ];
            $status = 200;
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'code' => 500
            ];
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function ujan_kuisoner_sekala($id, $kode)
    {


        $totalNilai = 0;
        $skorNilai = false;
        $kuisonersBenarSalah = [];
        $kuisoner = [];
        $sekala = Sekala::get();

        foreach ($sekala as $key => $value) {
            $kuisoners = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
                ->rightJoin('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
                ->leftJoin('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
                ->join('detail_kuisoner_sekalas', 'detail_kuisoner.id', '=', 'detail_kuisoner_sekalas.detail_kuisoner_id')
                ->join('sekalas', 'detail_kuisoner_sekalas.kode_sekala', '=', 'sekalas.kode')
                ->where('kuesioner_siswa.kode', $kode)
                ->where('sekalas.kode', $value->kode)
                ->select(
                    'kuesioner_siswa.*',
                    'detail_jawaban_kuesioner.kode as jawaban',
                    'detail_kuisoner.item as kuisoner_item',
                    'detail_jawaban_kuesioner.pilihan_kuesioner',
                    'detail_kuisoner_sekalas.kode_sekala',
                )
                ->get();

            $nilai = 0;

            foreach ($kuisoners as $k) {
                $itemType = $k->kuisoner_item;
                $jawaban = $k->jawaban;

                switch ($jawaban) {
                    case 'STS':
                        $nilai += ($itemType === 'pos') ? 5 : 1;
                        break;
                    case 'TS':
                        $nilai += ($itemType === 'pos') ? 4 : 2;
                        break;
                    case 'N':
                        $nilai += 3;
                        break;
                    case 'S':
                        $nilai += ($itemType === 'pos') ? 2 : 4;
                        break;
                    case 'SS':
                        $nilai += ($itemType === 'pos') ? 1 : 5;
                        break;
                    default:
                        $nilai += 0;
                        break;
                }
            }

            $kuisoner[] = [
                'kode_sekala' => $value->kode,
                'sekala' => $value->sekala,
                'nilai' => $nilai,
            ];
        }
 

        try {
            $kuisonerItem = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
                ->rightJoin('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
                ->leftJoin('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
                ->where('kuesioner_siswa.kode', $kode)
                ->select('kuesioner_siswa.*', 'detail_jawaban_kuesioner.kode as jawaban', 'detail_kuisoner.jenis_jawaban_kuesioner_id as jenis_jawaban_kuesioner_id')
                ->get()
                ->chunk(20)
                ->toArray();
            $ujian = Ujian::where('ujian.kode', $kode)
                ->leftJoin('detail_kuisoner', 'detail_kuisoner.kode', '=', 'ujian.kode')
                ->first();
            $response = [
                'status' => 'success',
                'data' => [
                    'ujian' => $ujian,
                    'kuisoner' => $kuisonerItem,
                    'sekala' => $sekala,
                    // 'facet' => $facet,
                    'skorNilai' => $skorNilai,
                    'kuisonersBenarSalah' => [
                        'totalNilai' => $totalNilai,
                        'kuisoner' =>  $kuisonersBenarSalah,
                    ],
                ],
                'message' => 'Data retrieved successfully',
                'code' => 200
            ];
            $status = 200;
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'code' => 500
            ];
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function ujan_visual($id, $kode)
    {
        try {
            $pg = VisualSiswa::where('siswa_id', $id)->where('kode', $kode)->get();

            foreach ($pg as $key => $value) {
                if (!$value->nilai || $value->nilai == 0 || $value->nilai == null) {
                    if (
                        (strtolower($value->jawaban_1) == strtolower($value->detailVisual->jawaban_1) || strtolower($value->jawaban_1) == strtolower($value->detailVisual->jawaban_2)) &&
                        (strtolower($value->jawaban_2) == strtolower($value->detailVisual->jawaban_1) || strtolower($value->jawaban_2) == strtolower($value->detailVisual->jawaban_2))
                    ) {
                        $value->nilai = 1;
                        $value->save();
                    } else {
                        $value->nilai = 0;
                        $value->save();
                    }
                }
            }
            $pg = VisualSiswa::where('siswa_id', $id)->where('kode', $kode)->get();
            $response = [
                'status' => 'success',
                'data' => $pg,
                'message' => 'Data retrieved successfully',
                'code' => 200
            ];
            $status = 200;
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'code' => 500
            ];
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function ujan_essay($id, $kode)
    {
        try {
            $essay = EssaySiswa::where('siswa_id', $id)->where('kode', $kode)->get();
            $ujian = Ujian::where('kode', $kode)->first();
            foreach ($essay as $key => $value) {
                if (!$value->nilai || $value->nilai == 0 || $value->nilai == null) {
                    // dd($value->detailessay->type_kunci_jawaban);
                    if ($value->detailessay->type_kunci_jawaban == 'text') {
                        if (empty($value->jawaban)) {
                            $kuciJawaban = null;
                        } else {
                            $kuciJawaban = JawabanEssay::where('detail_essay_id', $value->detailessay->id)
                                ->whereRaw('LOWER(jawaban) LIKE ?', ['%' . strtolower($value->jawaban) . '%'])
                                ->orderBy('nilai', 'desc')
                                ->first();
                        }
                    } else {
                        $kuciJawaban = JawabanEssay::where('detail_essay_id', $value->detailessay->id)
                            ->where('jawaban', $value->jawaban)
                            ->first();
                    }
                    if ($kuciJawaban) {
                        // echo "Jawaban: " . $value->jawaban . " | Kunci Jawaban: " . $kuciJawaban->jawaban . " | Nilai: " . $kuciJawaban->nilai . "<br>\n";
                        $value->nilai = $kuciJawaban->nilai;
                        $value->save();
                    } else {
                        // echo "Jawaban: " . $value->jawaban . " | Kunci Jawaban: Tidak ditemukan | Nilai: 0<br>\n";
                        $value->nilai = 0;
                        $value->save();
                    }
                }
            }
            $essay = EssaySiswa::where('siswa_id', $id)->where('kode', $kode)->get();
            // return false;
            // dd($essay);
            $response = [
                'status' => 'success',
                'data' => [
                    'ujian' => $ujian,
                    'essay' => $essay,
                ],
                'message' => 'Data retrieved successfully',
                'code' => 200
            ];
            $status = 200;
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'code' => 500
            ];
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function facet($id, $kode)
    {
        $results = [];

        $pgs = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->join('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->join('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->join('detail_kuisoner_facets', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner_facets.detail_kuisoner_id')
            ->where('kuesioner_siswa.kode', $kode)
            ->select(
                'kuesioner_siswa.*',
                'detail_jawaban_kuesioner.kode as jawaban',
                'detail_kuisoner_facets.*',
                'detail_kuisoner.item as kuisoner_item'
            )
            ->get();

        foreach ($pgs as $pg) {
            $jawabanKode = $pg->jawaban;
            $kuisonerItem = $pg->kuisoner_item;
            $score = 0;

            switch ($jawabanKode) {
                case 'STS':
                    $score = ($kuisonerItem == 'pos') ? 0 : 4;
                    break;
                case 'TS':
                    $score = ($kuisonerItem == 'pos') ? 1 : 3;
                    break;
                case 'N':
                    $score = 2;
                    break;
                case 'S':
                    $score = ($kuisonerItem == 'pos') ? 3 : 1;
                    break;
                case 'SS':
                    $score = ($kuisonerItem == 'pos') ? 4 : 0;
                    break;
                default:
                    $score = 0;
                    break;
            }

            $results[] = [
                'facet_code' => $pg->kode_facet,
                'jawaban_kode' => $jawabanKode,
                'kuisoner_item' => $kuisonerItem,
                'score' => $score
            ];
        }

        $domainFacet = Domain::with('domainFacet')->get();
        $facetCodes = [];

        foreach ($domainFacet as $value) {
            $facetCodes[] = [
                'deskripsi' => $value->deskripsi,
                'kode' => $value->kode,
                'facet' => $value->domainFacet->pluck('kode_facet')->toArray(),
            ];
        }

        $facet = [];

        foreach ($facetCodes as $value) {
            $domain = $value['deskripsi'];
            $filteredResults = array_filter($results, function ($result) use ($value) {
                return in_array($result['facet_code'], $value['facet']);
            });

            $totalScore = array_reduce($filteredResults, function ($carry, $item) {
                return $carry + $item['score'];
            }, 0);

            $facet[] = [
                'domain' => $domain,
                'results' => $filteredResults,
                'totalScore' => $totalScore,
            ];
        }

        return $facet;
    }

    function sekala($id, $kode)
    {
        $kuisoners = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->join('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->join('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->join('detail_kuisoner_sekalas', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner_sekalas.detail_kuisoner_id')
            ->join('sekalas', 'detail_kuisoner_sekalas.kode_sekala', '=', 'sekalas.kode')
            ->where('kuesioner_siswa.kode', $kode)
            ->select(
                'kuesioner_siswa.*',
                'detail_jawaban_kuesioner.kode as jawaban',
                'detail_kuisoner_sekalas.*',
                'sekalas.sekala as keterangan',
                'detail_kuisoner.item as kuisoner_item'
            )
            ->get();
        $results = [];
        if ($kuisoners->count() > 0) {
            foreach ($kuisoners as $kuisoner) {
                $jawabanKode = $kuisoner->jawaban;
                $kuisonerItem = $kuisoner->kuisoner_item;
                $score = 0;

                switch ($jawabanKode) {
                    case 'STS':
                        $score = ($kuisonerItem == 'pos') ? 5 : 1;
                        break;
                    case 'TS':
                        $score = ($kuisonerItem == 'pos') ? 4 : 2;
                        break;
                    case 'N':
                        $score = 3;
                        break;
                    case 'S':
                        $score = ($kuisonerItem == 'pos') ? 2 : 4;
                        break;
                    case 'SS':
                        $score = ($kuisonerItem == 'pos') ? 1 : 5;
                        break;
                    default:
                        $score = 0;
                        break;
                }

                $results[] = [
                    'kode_sekala' => $kuisoner->kode_sekala,
                    'jawaban_kode' => $jawabanKode,
                    'kuisoner_item' => $kuisonerItem,
                    'score' => $score,
                    'keterangan' => $kuisoner->keterangan
                ];
            }

            $groupedResults = collect($results)->groupBy('kode_sekala');
            $averageScores = [];
            foreach ($groupedResults as $kode_sekala => $items) {
                $totalScore = $items->sum('score');
                $count = $items->count();
                $averageScore = $totalScore / $count;

                // Round the average score to the nearest integer
                $averageScore = number_format($averageScore, 2);

                $averageScores[] = [
                    'kode_sekala' => $kode_sekala,
                    'average_score' => $averageScore,
                    'total_score' => $totalScore,
                    'count' => $count,
                    'keterangan' => $items->first()['keterangan']
                ];
            }

            $totalAverageScore = collect($averageScores)->sum('total_score') / count($averageScores);
            return [
                'average_scores' => $averageScores,
                'total_average_score' => number_format($totalAverageScore, 2)
            ];
        } else {
            return [
                'average_scores' => [],
                'total_average_score' => 0
            ];
        }
    }
}
