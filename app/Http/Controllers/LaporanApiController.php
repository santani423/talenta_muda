<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\EssaySiswa;
use App\Models\JawabanEssay;
use App\Models\Kelas;
use App\Models\KlasifikasiIq;
use App\Models\KuesionerSiswa;
use App\Models\PgSiswa;
use App\Models\Siswa;
use App\Models\SkorKalender;
use App\Models\Ujian;
use App\Models\VisualSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanApiController extends Controller
{
    // GET /api/laporan/siswa?search=&batch=&limit=10&page=1
    public function siswa(Request $request)
    {
        $search   = $request->input('search');
        $kelasId  = $request->input('batch');
        $perPage  = $request->input('limit', 10);
        $page     = $request->input('page', 1);

        $query = Siswa::with('kelas')
            ->when($search, fn($q) => $q->where('nama_siswa', 'like', "%{$search}%"))
            ->when($kelasId, fn($q) => $q->where('kelas_id', $kelasId))
            ->orderBy('id', 'asc');

        $paginated = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'data'   => $paginated->items(),
            'meta'   => [
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
                'per_page'     => $paginated->perPage(),
                'total'        => $paginated->total(),
                'from'         => $paginated->firstItem(),
                'to'           => $paginated->lastItem(),
            ],
        ]);
    }

    // GET /api/laporan/batch
    public function batch()
    {
        return response()->json([
            'status' => 'success',
            'data'   => Kelas::orderBy('nama_kelas')->get(['id', 'nama_kelas']),
        ]);
    }

    // GET /api/laporan/siswa/{id}/semua-nilai
    public function semuaNilai(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $parts = [
            ['kode' => 'part1_1', 'type' => 'pg'],
            ['kode' => 'part1_2', 'type' => 'visual'],
            ['kode' => 'part1_3', 'type' => 'pg'],
            ['kode' => 'part1_4', 'type' => 'pg'],
            ['kode' => 'part2',   'type' => 'essay'],
            ['kode' => 'part3',   'type' => 'essay'],
            ['kode' => 'part4',   'type' => 'essay'],
            ['kode' => 'part5_1', 'type' => 'kuisoner'],
            ['kode' => 'part5_2', 'type' => 'kuisoner'],
            ['kode' => 'part5_3', 'type' => 'kuisoner'],
        ];

        $results = [];
        $nilaiTscore = 0;
        $nilaiARTd   = 0;
        $nilaiSIM    = 0;

        foreach ($parts as $part) {
            $kode = $part['kode'];
            switch ($part['type']) {
                case 'pg':
                    $data = $this->scorePg($id, $kode);
                    break;
                case 'visual':
                    $data = $this->scoreVisual($id, $kode);
                    break;
                case 'essay':
                    $data = $this->scoreEssay($id, $kode);
                    break;
                case 'kuisoner':
                    $data = $this->scoreKuisoner($id, $kode);
                    break;
                default:
                    $data = ['codeUjian' => $kode, 'nilai' => 0, 'typeUjian' => 0, 'siswa' => [], 'ujian' => null];
            }

            if (in_array($kode, ['part1_1', 'part1_2', 'part1_3', 'part1_4'])) {
                $nilaiTscore += (int)($data['nilai'] ?? 0);
            }
            if ($kode === 'part1_3') {
                $nilaiARTd = (int)($data['nilai'] ?? 0);
            }
            if ($kode === 'part4') {
                $nilaiSIM = (int)($data['nilai'] ?? 0);
            }

            $results[$kode] = $data;
        }

        // Hitung T-Score & klasifikasi IQ
        $tscore = $this->calcTScore($nilaiTscore, $siswa->tanggal_lahir);

        return response()->json([
            'status'    => 'success',
            'siswa'     => [
                'id'            => $siswa->id,
                'nama_siswa'    => $siswa->nama_siswa,
                'tanggal_lahir' => $siswa->tanggal_lahir,
                'tempat_lahir'  => $siswa->tempat_lahir,
                'gender'        => $siswa->gender,
                'umur'          => $siswa->umur,
                'kelas'         => $siswa->kelas,
            ],
            'nilai' => [
                'tscore'     => $nilaiTscore,
                'artd'       => $nilaiARTd,
                'sim'        => $nilaiSIM,
                'skor_iq'    => $tscore['kalenderScore']['nilai']        ?? '-',
                'kualifikasi'=> $tscore['klasifikasi']['klasifikasi']    ?? '-',
            ],
            'parts' => $results,
        ]);
    }

    // ─── Private scoring helpers ───────────────────────────────────────────

    private function scorePg($id, $kode)
    {
        $rows = PgSiswa::where('siswa_id', $id)->where('kode', $kode)->get();
        $ujianNama = null;
        $niaiTambah = 0;
        $total = 0;
        $siswa = [];

        foreach ($rows as $r) {
            if (!$r->nilai || $r->nilai == 0) {
                $r->nilai = strtolower($r->jawaban) == strtolower($r->detailujian->jawaban ?? '') ? 1 : 0;
                $r->save();
            }
            $total += (int)$r->nilai;
            $ujianNama  = $r->ujian->nama_ujian ?? $kode;
            $niaiTambah = $r->ujian->nilai_tambahan ?? 0;
            $siswa[] = [
                'jawaban'        => $r->jawaban,
                'kunci_jawaban'  => $r->detailujian->jawaban ?? null,
                'nilai'          => $r->nilai,
            ];
        }

        return [
            'codeUjian'  => $kode,
            'type'       => $ujianNama ?? $kode,
            'typeUjian'  => 0,
            'nilai'      => $total,
            'niaiTambah' => $niaiTambah,
            'siswa'      => $siswa,
        ];
    }

    private function scoreVisual($id, $kode)
    {
        $rows = VisualSiswa::where('siswa_id', $id)->where('kode', $kode)->get();
        $ujianNama = null;
        $total = 0;
        $siswa = [];

        foreach ($rows as $r) {
            if (!$r->nilai || $r->nilai == 0) {
                $dv = $r->detailVisual;
                $r->nilai = (
                    (strtolower($r->jawaban_1) == strtolower($dv->jawaban_1 ?? '') || strtolower($r->jawaban_1) == strtolower($dv->jawaban_2 ?? '')) &&
                    (strtolower($r->jawaban_2) == strtolower($dv->jawaban_1 ?? '') || strtolower($r->jawaban_2) == strtolower($dv->jawaban_2 ?? ''))
                ) ? 1 : 0;
                $r->save();
            }
            $total += (int)$r->nilai;
            $ujianNama = $r->ujian->nama_ujian ?? $kode;
            $siswa[] = [
                'jawaban' => $r->jawaban_1 . '-' . $r->jawaban_2,
                'nilai'   => $r->nilai,
            ];
        }

        return [
            'codeUjian'  => $kode,
            'type'       => $ujianNama ?? $kode,
            'typeUjian'  => 3,
            'nilai'      => $total,
            'niaiTambah' => 0,
            'siswa'      => $siswa,
        ];
    }

    private function scoreEssay($id, $kode)
    {
        $rows  = EssaySiswa::where('siswa_id', $id)->where('kode', $kode)->get();
        $ujian = Ujian::where('kode', $kode)->first();
        $total = 0;
        $siswa = [];

        foreach ($rows as $r) {
            if (!$r->nilai || $r->nilai == 0) {
                $de = $r->detailessay;
                if ($de->type_kunci_jawaban == 'text') {
                    $kunci = empty($r->jawaban) ? null
                        : JawabanEssay::where('detail_essay_id', $de->id)
                            ->whereRaw('LOWER(jawaban) LIKE ?', ['%' . strtolower($r->jawaban) . '%'])
                            ->orderBy('nilai', 'desc')->first();
                } else {
                    $kunci = JawabanEssay::where('detail_essay_id', $de->id)->where('jawaban', $r->jawaban)->first();
                }
                $r->nilai = $kunci ? $kunci->nilai : 0;
                $r->save();
            }
            $total += (int)$r->nilai;
            $siswa[] = [
                'jawaban'      => $r->jawaban,
                'nilai'        => $r->nilai,
                'jawaban_essay'=> $r->detailessay,
            ];
        }

        return [
            'codeUjian'  => $kode,
            'type'       => $ujian->nama_ujian ?? $kode,
            'typeUjian'  => 1,
            'nilai'      => $total,
            'niaiTambah' => $ujian->nilai_tambahan ?? 0,
            'siswa'      => $siswa,
            'ujian'      => $ujian,
        ];
    }

    private function scoreKuisoner($id, $kode)
    {
        $facet  = $this->calcFacet($id, $kode);
        $sekala = $this->calcSekala($id, $kode);

        $kuisonerItems = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->rightJoin('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->leftJoin('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->where('kuesioner_siswa.kode', $kode)
            ->select('kuesioner_siswa.*', 'detail_jawaban_kuesioner.kode as jawaban', 'detail_kuisoner.jenis_jawaban_kuesioner_id')
            ->get()->chunk(20)->toArray();

        $ujian = Ujian::where('ujian.kode', $kode)
            ->leftJoin('detail_kuisoner', 'detail_kuisoner.kode', '=', 'ujian.kode')
            ->first();

        // benar/salah scoring
        $totalNilai = 0;
        $skorNilai  = false;
        $kuisoners = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->rightJoin('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->leftJoin('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->where('kuesioner_siswa.kode', $kode)
            ->select('kuesioner_siswa.*', 'detail_jawaban_kuesioner.kode as jawaban', 'detail_kuisoner.item as kuisoner_item')
            ->get();

        foreach ($kuisoners as $k) {
            if (str_replace(' ', '', $k->jawaban) == str_replace(' ', '', $k->detailKuisoner[0]->jawaban ?? '')) {
                $k->nilai = 1;
            } else {
                $k->nilai = 0;
            }
            if (!empty($k->detailKuisoner[0]->jawaban)) {
                $skorNilai = true;
            }
            $totalNilai += $k->nilai;
        }

        return [
            'codeUjian'          => $kode,
            'type'               => $ujian->nama_ujian ?? $kode,
            'typeUjian'          => 2,
            'nilai'              => $totalNilai,
            'niaiTambah'         => 0,
            'skorNilai'          => $skorNilai,
            'siswa'              => $kuisonerItems,
            'facet'              => $facet,
            'sekala'             => $sekala,
            'ujian'              => $ujian,
            'kuisonersBenarSalah'=> ['totalNilai' => $totalNilai],
        ];
    }

    private function calcFacet($id, $kode)
    {
        $pgs = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->join('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->join('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->join('detail_kuisoner_facets', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner_facets.detail_kuisoner_id')
            ->join('facets', 'facets.code', '=', 'detail_kuisoner_facets.kode_facet')
            ->where('kuesioner_siswa.kode', $kode)
            ->select('kuesioner_siswa.*', 'detail_jawaban_kuesioner.kode as jawaban',
                'detail_kuisoner_facets.*', 'facets.deskripsi as deskripsi_facet',
                'facets.code as code_facet', 'detail_kuisoner.item as kuisoner_item')
            ->get();

        $results = [];
        foreach ($pgs as $pg) {
            $j = $pg->jawaban;
            $t = $pg->kuisoner_item;
            $score = match($j) {
                'STS' => ($t == 'pos') ? 0 : 4,
                'TS'  => ($t == 'pos') ? 1 : 3,
                'N'   => 2,
                'S'   => ($t == 'pos') ? 3 : 1,
                'SS'  => ($t == 'pos') ? 4 : 0,
                default => 0,
            };
            $results[] = [
                'facet_code'     => $pg->kode_facet,
                'deskripsi_facet'=> $pg->deskripsi_facet,
                'code_facet'     => $pg->code_facet,
                'jawaban_kode'   => $j,
                'kuisoner_item'  => $t,
                'score'          => $score,
            ];
        }

        $domainFacet = Domain::with('domainFacet')->get();
        $facetCodes  = $domainFacet->map(fn($d) => [
            'deskripsi' => $d->deskripsi,
            'kode'      => $d->kode,
            'facet'     => $d->domainFacet->pluck('kode_facet')->toArray(),
        ])->toArray();

        $facet = [];
        foreach ($facetCodes as $value) {
            $filtered = array_filter($results, fn($r) => in_array($r['facet_code'], $value['facet']));
            $grouped  = [];

            foreach ($filtered as $item) {
                $parts    = preg_split('/[\s-]+/', strtolower($item['deskripsi_facet']));
                $key      = array_shift($parts);
                $camelKey = $key . implode('', array_map('ucfirst', $parts));

                if (!isset($grouped[$key])) {
                    $grouped[$key] = [
                        'deskripsi_facet' => $key,
                        'code_facet'      => $item['code_facet'],
                        'total_score'     => 0,
                        'items'           => [],
                    ];
                }
                $grouped[$key]['total_score'] += $item['score'];
                $grouped[$key]['items'][]      = $item;
            }

            $totalScore = array_reduce($filtered, fn($c, $i) => $c + $i['score'], 0);
            $totalItems = count($filtered);

            $facet[] = [
                'domain'          => $value['deskripsi'],
                'subdomain'       => $grouped,
                'totalScore'      => $totalScore,
                'totalCountScore' => $totalItems > 0 ? $totalScore / $totalItems : 0,
            ];
        }

        return $facet;
    }

    private function calcSekala($id, $kode)
    {
        $kuisoners = KuesionerSiswa::where('kuesioner_siswa.siswa_id', $id)
            ->join('detail_kuisoner', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->join('detail_jawaban_kuesioner', 'kuesioner_siswa.detail_jawaban_kuesioner_id', '=', 'detail_jawaban_kuesioner.id')
            ->join('detail_kuisoner_sekalas', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner_sekalas.detail_kuisoner_id')
            ->join('sekalas', 'detail_kuisoner_sekalas.kode_sekala', '=', 'sekalas.kode')
            ->where('kuesioner_siswa.kode', $kode)
            ->select('kuesioner_siswa.*', 'detail_jawaban_kuesioner.kode as jawaban',
                'detail_kuisoner_sekalas.*', 'sekalas.sekala as keterangan',
                'detail_kuisoner.item as kuisoner_item', 'detail_kuisoner.jawaban as kuisoner_jawaban')
            ->get();

        if ($kuisoners->isEmpty()) {
            return ['average_scores' => [], 'total_average_score' => 0, 'totalNilai' => 0];
        }

        $results = [];
        foreach ($kuisoners as $k) {
            $j      = $k->jawaban;
            $t      = $k->kuisoner_item;
            $jawaban = str_replace(' ', '', $k->kuisoner_jawaban);
            $score  = $jawaban
                ? ($jawaban == $j ? 1 : 0)
                : match($j) {
                    'STS' => ($t == 'pos') ? 5 : 1,
                    'TS'  => ($t == 'pos') ? 4 : 2,
                    'N'   => 3,
                    'S'   => ($t == 'pos') ? 2 : 4,
                    'SS'  => ($t == 'pos') ? 1 : 5,
                    default => 0,
                };

            $results[] = [
                'kode_sekala' => $k->kode_sekala,
                'score'       => $score,
                'keterangan'  => $k->keterangan,
            ];
        }

        $grouped      = collect($results)->groupBy('kode_sekala');
        $averageScores = [];
        foreach ($grouped as $kode_sekala => $items) {
            $totalScore    = $items->sum('score');
            $count         = $items->count();
            $averageScores[] = [
                'kode_sekala'   => $kode_sekala,
                'average_score' => number_format($totalScore / $count, 2),
                'total_score'   => $totalScore,
                'count'         => $count,
                'keterangan'    => $items->first()['keterangan'],
            ];
        }

        $totalAvg   = collect($averageScores)->sum('total_score') / count($averageScores);
        $totalNilai = collect($averageScores)->sum('total_score');

        return [
            'average_scores'      => $averageScores,
            'total_average_score' => number_format($totalAvg, 2),
            'totalNilai'          => number_format($totalNilai, 2),
        ];
    }

    private function calcTScore($nilai, $tanggalLahir)
    {
        try {
            $birth       = Carbon::parse($tanggalLahir);
            $now         = Carbon::now();
            $tahun       = $now->diffInYears($birth);
            $bulan       = $now->diffInMonths($birth) % 12;
            $umur        = $tahun + ($bulan / 12);

            $kalenderScore = SkorKalender::where('total_raw_score', $nilai)
                ->whereRaw('(CONVERT(usia_dari_tahun, UNSIGNED) + CONVERT(usia_dari_bulan, UNSIGNED)/12) <= ?', [$umur])
                ->whereRaw('(CONVERT(usia_sampai_tahun, UNSIGNED) + CONVERT(usia_sampai_bulan, UNSIGNED)/12) >= ?', [$umur])
                ->first();

            $nilaiIQ = $kalenderScore->nilai ?? 0;
            $klasifikasi = KlasifikasiIq::where('iq_min', '<=', $nilaiIQ)
                ->where(fn($q) => $q->where('iq_max', '>=', $nilaiIQ)->orWhereNull('iq_max'))
                ->first();

            return [
                'kalenderScore' => $kalenderScore,
                'klasifikasi'   => $klasifikasi,
            ];
        } catch (\Exception $e) {
            return ['kalenderScore' => null, 'klasifikasi' => null];
        }
    }
}
