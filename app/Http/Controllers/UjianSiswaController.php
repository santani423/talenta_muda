<?php

namespace App\Http\Controllers;

use App\Models\DetailEssay;
use App\Models\DetailUjian;
use App\Models\EssaySiswa;
use App\Models\MergeUjian;
use App\Models\Notifikasi;
use App\Models\PgSiswa;
use App\Models\Siswa;
use App\Models\TugasSiswa;
use App\Models\Ujian;
use App\Models\WaktuUjian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Service\UjianServiceController;
use App\Models\DetailKuisoner;
use App\Models\DetailVisual;
use App\Models\IntruksiUjian;
use App\Models\KuesionerSiswa;
use App\Models\SimulasiUjianEssay;
use App\Models\SimulatorUjianPg;
use App\Models\SimulatorUjianVisual;
use App\Models\VisualSiswa;
use Carbon\Carbon;

class UjianSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();
        $ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->orderBy('id', 'desc')
            ->get();


        return view('siswa.ujian.index', [
            'title' => 'Data Ujian',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'ujian' => $ujian
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all()[2999] ?? null);
        // dd($request->all());
        $pg_siswa = PgSiswa::where('kode', $request->kode)->where('siswa_id', session()->get('id'))->get();

        foreach ($pg_siswa as $key => $value) {
            $pilihanKey = "pilihan-" . $value->detail_ujian_id;

            // Check if the request has this key and is not null
            if ($request->has($pilihanKey)) {
                $pgs = PgSiswa::where('kode', $request->kode)
                    ->where('siswa_id', session()->get('id'))
                    ->where('detail_ujian_id', $value->detail_ujian_id)
                    ->update(['jawaban' => $request->input($pilihanKey)]);
            }
        }
        // dd($request->kode);
        //   $waktu_ujian =  WaktuUjian::where('kode', $request->kode)
        //     ->where('siswa_id', session()->get('id'))
        //     ->get();
        //     // ->update([
        //     //     'selesai' => 1
        //     // ]);
        $waktu_ujian =  WaktuUjian::where('kode', $request->kode)
            ->where('siswa_id', session()->get('id'))
            ->update([
                'selesai' => 1
            ]);
        // dd($waktu_ujian);

        // dd(session()->get('id'));
        return redirect('/siswa/instruksi/' . $request->kode_merge_ujian)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah dikerjakan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function store_essay(Request $request)
    {
        $essay_siswa = EssaySiswa::where('kode', $request->kode)->where('siswa_id', session()->get('id'))->get();
        // dd($essay_siswa);
        foreach ($essay_siswa as   $value) {
            $pilihanKey = "jawaban-" . $value->detail_ujian_id;

            // Check if the request has this key and is not null

            EssaySiswa::where('kode', $request->kode)
                ->where('siswa_id', session()->get('id'))
                ->where('detail_ujian_id', $value->detail_ujian_id)
                ->update(['jawaban' => $request->input($pilihanKey)]);
        }
        // dd($request->all());
        // dd($essay_siswa);
        WaktuUjian::where('kode', $request->kode)
            ->where('siswa_id', session()->get('id'))
            ->update(['selesai' => 1]);
        return redirect('/siswa/instruksi/' . $request->kode_merge_ujian)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah dikerjakan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ujian  $ujian
     * @return \Illuminate\Http\Response
     */
    public function show($kodeMergeUjian)
    {
        $mergeUjian = MergeUjian::where('merge_ujian.kode', $kodeMergeUjian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->join('waktu_ujian', 'waktu_ujian.kode', '=', 'ujian.kode')
            // ->leftJoin('waktu_ujian', function ($join) use ($kodeMergeUjian) {
            //     $join->on('waktu_ujian.kode', '=', 'ujian.kode')
            //         ->where('waktu_ujian.siswa_id', '=', session()->get('id'));
            // })
            ->where('waktu_ujian.selesai', '!=', 1)
            ->where('waktu_ujian.siswa_id', session()->get('id'))
            ->select(
                'rum.*',
                'waktu_ujian.*',
                'ujian.jenis as jenis_ujian',
                'ujian.kode as kode_ujian',
                'merge_ujian.jam',
                'merge_ujian.menit',
                'merge_ujian.kode as merge_ujian_kode'
            )

            ->distinct('rum.id')
            ->orderBy('rum.urutan', 'asc')
            ->first();

        // dd($mergeUjian);

        if (!$mergeUjian) {
            return redirect(url('siswa/slide/' . $kodeMergeUjian));
        }


        $ujian = UjianServiceController::createOrRetrievePgSiswa($mergeUjian->kode_ujian);


        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();


        UjianServiceController::startUJian($ujian->kode,$kodeMergeUjian);
        // dd(7);

        $waktu_ujian = WaktuUjian::where('kode', $ujian->kode)
            ->where('siswa_id', session()->get('id'))
            ->first();

        $pg_siswa = PgSiswa::where('kode', $mergeUjian->kode_ujian)
            ->where('siswa_id', session()->get('id'))
            ->get();
        // dd($mergeUjian);
        return view('siswa.ujian.merge-ujian-show', [
            'title' => 'Ujian Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'ujian' => $ujian,
            'pg_siswa' => $pg_siswa,
            'kode_merge_ujian' => $mergeUjian->kode_merge_ujian,
            'waktu_ujian' => $waktu_ujian
        ]);
    }

    public function cek_waktu_ujian(Request $request)
    {

        // Ambil data merge ujian
        // $mergeUjian = MergeUjian::where('merge_ujian.kode', $request->kode_merge_ujian)
        //     ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
        //     ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
        //     ->join('waktu_ujian', 'waktu_ujian.kode', '=', 'ujian.kode')
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
        // dd(count($mergeUjian));
        // // dd($request->all());
        // $ujian = Ujian::where('kode', $request->kode_ujian)
        //     ->first();
        // if (count($mergeUjian) < 2) {

        //     $cekWaktu = $this->cekSisaWaktuUjian($request->waktu_ujian_id, $request->kode_ujian);
        //     // Anda bisa memproses hasil $cekWaktu sesuai kebutuhan, misal logging atau return response

        //     return $cekWaktu;
        // } else {
        //     // dd($mergeUjian);
        //     $data1 = $mergeUjian[0];
        //     $data2 = $mergeUjian[1];
        //     $totalMenit = $this->hitungRentangWaktuDalamMenit($data1->waktu_mulai, $data2->waktu_mulai);
        //     $jam = $ujian->jam;
        //     $menit =  $ujian->menit;


        //     $batasWaktuMenit = ($jam * 60) + $menit;
        //     if ($totalMenit >= $batasWaktuMenit) {
        //         $cekWaktu = $this->cekSisaWaktuUjian($request->waktu_ujian_id, $request->kode_ujian);
        //         return response()->json(['status' => 'expired', 'message' => 'Waktu ujian telah habis.']);
        //     }
        //     dd($totalMenit);
        // }
    }

    function hitungRentangWaktuDalamMenit($startDateTime, $endDateTime)
    {
        $start = Carbon::parse($startDateTime);
        $end = Carbon::parse($endDateTime);

        return $start->diffInMinutes($end);
    }

    public function cekSisaWaktuUjian($waktu_ujian_id, $kode_ujian = null)
    {
        $ujian = Ujian::where('kode', $kode_ujian)
            ->first();
        $waktu_ujian = WaktuUjian::where('id', $waktu_ujian_id)
            ->where('siswa_id', session()->get('id'))
            ->first();

        if (!$waktu_ujian) {
            return response()->json(['message' => 'Waktu ujian tidak ditemukan'], 404);
        }
        $jam = $ujian->jam;
        $menit =  $ujian->menit;


        $batasWaktuMenit = ($jam * 60) + $menit;

        $targetTime = Carbon::parse($waktu_ujian->waktu_mulai);
        $now = Carbon::now();
        $waktuAkhir = $targetTime->copy()->addMinutes($batasWaktuMenit);

        if ($now->greaterThan($waktuAkhir)) {
            return response()->json(['status' => 'expired', 'message' => 'Waktu ujian telah habis.']);
        } else {
            $diffInMinutes = $now->diffInMinutes($waktuAkhir, false);
            $jam = floor($diffInMinutes / 60);
            $menit = $diffInMinutes % 60;

            return response()->json([
                'status' => 'active',
                'message' => "Sisa waktu ujian: $jam jam $menit menit lagi.",
                'jam' => $jam,
                'menit' => $menit
            ]);
        }
    }




    public function essay($ujian)
    {
        $mergeUjian = MergeUjian::where('merge_ujian.kode', $ujian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->join('waktu_ujian', 'waktu_ujian.kode', '=', 'ujian.kode')
            // ->leftJoin('waktu_ujian', function ($join) use ($ujian) {
            //     $join->on('waktu_ujian.kode', '=', 'ujian.kode')
            //         ->where('waktu_ujian.siswa_id', '=', session()->get('id'));
            // })
            ->where('waktu_ujian.selesai', '!=', 1)
            ->where('ujian.jenis', 1)
            ->where('waktu_ujian.siswa_id', session()->get('id'))
            ->select(
                'rum.*',
                'waktu_ujian.*',
                'ujian.jenis as jenis_ujian',
                'ujian.kode as kode_ujian',
                'merge_ujian.jam',
                'merge_ujian.menit',
                'merge_ujian.kode as merge_ujian_kode'
            )

            ->distinct('rum.id')
            ->orderBy('rum.urutan', 'asc')
            ->first();

        // dd($mergeUjian);
        if (!$mergeUjian) {
            return redirect(url('siswa/slide/' . $ujian));
        }
        $ujian = Ujian::where('kode', $mergeUjian->kode_ujian)->first();
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        $essay_siswa = EssaySiswa::where('kode', $ujian->kode)

            ->where('siswa_id', session()->get('id'))
            ->get();

        if ($essay_siswa->count() == 0) {
            $data_essay_siswa = [];
            foreach ($ujian->detailessay as $soal) {
                array_push($data_essay_siswa, [
                    'detail_ujian_id' => $soal->id,
                    'kode' => $soal->kode,
                    'siswa_id' => session()->get('id')
                ]);
            }
            EssaySiswa::insert($data_essay_siswa);
        }
        UjianServiceController::startUJian($mergeUjian->kode_ujian, $ujian);

        $waktu_ujian = WaktuUjian::where('kode', $mergeUjian->kode_ujian)
            ->where('siswa_id', session()->get('id'))
            ->first();
        $essay_siswa = DetailEssay::where('kode', $mergeUjian->kode_ujian)
            ->get();
        // $essay_siswa = EssaySiswa::where('essay_siswa.kode', $mergeUjian->kode_ujian)
        //     ->join('detail_essay', 'detail_essay.kode', 'essay_siswa.kode')
        //     ->where('siswa_id', session()->get('id'))
        //     ->get();
        // dd($essay_siswa);
        return view('siswa.ujian.show-essay', [
            'title' => 'Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'ujian' => $ujian,
            'essay_siswa' => $essay_siswa,
            'kode_merge_ujian' => $mergeUjian->merge_ujian_kode,
            'waktu_ujian' => $waktu_ujian
        ]);
    }
    public function ujian_visual($kodeMergeUjian)
    {

        $mergeUjian = MergeUjian::where('merge_ujian.kode', $kodeMergeUjian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->leftJoin('waktu_ujian', function ($join) use ($kodeMergeUjian) {
                $join->on('waktu_ujian.kode', '=', 'ujian.kode')
                    ->where('waktu_ujian.siswa_id', '=', session()->get('id'));
            })
            ->where('waktu_ujian.selesai', '!=', 1)

            ->select(
                'rum.*',
                'waktu_ujian.*',
                'ujian.jenis as jenis_ujian',
                'ujian.kode as kode_ujian',
                'merge_ujian.jam',
                'merge_ujian.menit',
                'merge_ujian.kode as merge_ujian_kode'
            )

            ->distinct('rum.id')
            ->orderBy('rum.urutan', 'asc')
            ->first();

        // dd($mergeUjian);

        if (!$mergeUjian) {
            return redirect(url('siswa/slide/' . $kodeMergeUjian));
        }


        UjianServiceController::startUJian($mergeUjian->kode_ujian,$kodeMergeUjian);



        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();



        $waktu_ujian = WaktuUjian::where('kode', $mergeUjian->kode_ujian)
            ->where('siswa_id', session()->get('id'))
            ->first();

        $visual_siswa = VisualSiswa::where('kode', $mergeUjian->kode_ujian)
            ->where('siswa_id', session()->get('id'))
            ->get();

        // dd($visual_siswa);
        return view('siswa.ujian.merge-ujian-visual', [
            'title' => 'Ujian Pilihan Ganda',
            'plugin' => '
            <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
            <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
        ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'ujian' => $mergeUjian,
            'visual_siswa' => $visual_siswa,
            'kode_merge_ujian' => $mergeUjian->kode_merge_ujian,
            'waktu_ujian' => $waktu_ujian
        ]);
    }

    function store_ujian_visual(Request $request)
    {
        // Mengambil data VisualSiswa berdasarkan kode dan siswa_id
        $visual_siswa = VisualSiswa::where('kode', $request->kode)
            ->where('siswa_id', session()->get('id'))
            ->get();
        // dd($request->all());
        // Loop melalui data visual_siswa
        foreach ($visual_siswa as $value) {
            $pilihanKey = "pilihan-" . $value->detail_visual_id;
            // dd($pilihanKey);
            // Mengecek apakah request memiliki data untuk key tersebut dan memiliki lebih dari 1 jawaban
            if ($request->has($pilihanKey) && is_array($request->input($pilihanKey)) && count($request->input($pilihanKey)) > 1) {
                // Mengambil jawaban 1 dan jawaban 2 dari input
                $jawaban_1 = $request->input($pilihanKey)[0];
                $jawaban_2 = $request->input($pilihanKey)[1];

                // Melakukan update pada VisualSiswa
                VisualSiswa::where('kode', $request->kode)
                    ->where('siswa_id', session()->get('id'))
                    ->where('detail_visual_id', $value->detail_visual_id)
                    ->update([
                        'jawaban_1' => $jawaban_1,
                        'jawaban_2' => $jawaban_2,
                    ]);
            }
        }

        WaktuUjian::where('kode', $request->kode)
            ->where('siswa_id', session()->get('id'))
            ->update([
                'selesai' => '1'
            ]);
        // dd($request->kode);
        return redirect('/siswa/instruksi/' . $request->kode_merge_ujian)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah dikerjakan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }



    public function ujian_kuesioner($kodeMergeUjian)
    {
        $mergeUjian = MergeUjian::where('merge_ujian.kode', $kodeMergeUjian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->leftJoin('waktu_ujian', function ($join) use ($kodeMergeUjian) {
                $join->on('waktu_ujian.kode', '=', 'ujian.kode')
                    ->where('waktu_ujian.siswa_id', '=', session()->get('id'));
            })
            ->where('waktu_ujian.selesai', '!=', 1)
            ->select(
                'rum.*',
                'waktu_ujian.*',
                'ujian.jenis as jenis_ujian',
                'merge_ujian.jam',
                'merge_ujian.menit',
                'merge_ujian.kode as merge_ujian_kode'
            )
            ->distinct('rum.id')
            ->orderBy('rum.urutan', 'asc')
            ->first();

        // dd($mergeUjian);

        if (!$mergeUjian) {
            return redirect(url('siswa/slide/' . $kodeMergeUjian));
        }


        $ujian = UjianServiceController::createOrRetrieveKuesionerSiswa($mergeUjian->kode_ujian);



        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        UjianServiceController::setEndTimeForExam($kodeMergeUjian);
        UjianServiceController::startUJian($mergeUjian->kode_ujian,$kodeMergeUjian);

        $waktu_ujian = WaktuUjian::where('kode', $mergeUjian->kode_ujian)
            ->where('siswa_id', session()->get('id'))
            ->first();


        $detail_siswa = DetailKuisoner::where('kode', $mergeUjian->kode_ujian)
            ->get();
        //     dd(session()->get('id'));
        // dd($mergeUjian->kode_ujian);
        foreach ($detail_siswa as $value) {
            $kuiosnerSiswa = KuesionerSiswa::where('detail_kuisoner', $value->id)
                ->where('kode', $mergeUjian->kode_ujian)
                ->where('siswa_id', session()->get('id'))
                ->first();
            if (!$kuiosnerSiswa) {
                KuesionerSiswa::create([
                    'detail_kuisoner' => $value->id,
                    'kode' => $mergeUjian->kode_ujian,
                    'siswa_id' => session()->get('id')
                ]);
            }
        }


        $detail_siswa = DetailKuisoner::where('kode', $mergeUjian->kode_ujian)
            ->get()
            ->chunk(10)
            ->toArray();





        // dd($detail_siswa);
        return view('siswa.ujian.merge-ujian-kuisoner', [
            'title' => 'Ujian Pilihan Ganda',
            'plugin' => '
            <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
            <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
        ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'ujian' => $mergeUjian,
            'detail_siswa' => $detail_siswa,
            'kode_merge_ujian' => $mergeUjian->kode_merge_ujian,
            'waktu_ujian' => $waktu_ujian
        ]);
    }

    function store_ujian_kuesioner(Request $request)
    {
        $detail_kuisoner = DetailKuisoner::where('kode', $request->kode)->get();
        // dd($request);
        foreach ($detail_kuisoner as $value) {
            // Tentukan key untuk input radio jawaban
            $pilihanKey = "jawaban_" . $value->id;

            // Cek apakah jawaban ada dalam request dan key tersebut memiliki nilai
            if ($request->has($pilihanKey)) {
                // Ambil nilai jawaban dari request
                $jawabanId = $request->input($pilihanKey);

                // Update data KuesionerSiswa
                KuesionerSiswa::where('kode', $request->kode)
                    ->where('detail_kuisoner', $value->id)
                    ->where('siswa_id', session()->get('id'))
                    ->update(['detail_jawaban_kuesioner_id' => $jawabanId]);
            }
        }
        WaktuUjian::where('kode', $request->kode)
            ->where('siswa_id', session()->get('id'))
            ->update(['selesai' => 1]);
        return redirect('/siswa/instruksi/' . $request->kode_merge_ujian)->with('pesan', "
        <script>
            swal({
                title: 'Success!',
                text: 'ujian sudah dikerjakan!',
                type: 'success',
                padding: '2em'
            })
        </script>
    ");
    }



    public function slide($ujian)
    {


        UjianServiceController::setEndTimeForExam($ujian);

        $mergeUjian = MergeUjian::where('merge_ujian.kode', $ujian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->leftJoin('waktu_ujian', function ($join) use ($ujian) {
                $join->on('waktu_ujian.kode', '=', 'ujian.kode')
                    ->where('waktu_ujian.siswa_id', '=', session()->get('id'));
            })
            ->where('waktu_ujian.selesai', '!=', 1)
            ->select(
                'rum.*',
                'waktu_ujian.*',
                'ujian.jenis as jenis_ujian',
                'merge_ujian.jam',
                'merge_ujian.menit',
                'merge_ujian.kode as merge_ujian_kode'
            )
            ->distinct('rum.id')
            ->orderBy('rum.urutan', 'asc')
            ->first();


        // dd($mergeUjian);

        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();
        return view('siswa.ujian.merge-ujian-slide', [
            'title' => 'Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'mergeUjian' => $mergeUjian,
            'ujian' => $ujian,
        ]);
    }
    public function instruksi($ujian)
    {

        try {
            // Atur waktu selesai ujian
            UjianServiceController::setEndTimeForExam($ujian);

            // Ambil data merge ujian
            $mergeUjian = MergeUjian::where('merge_ujian.kode', $ujian)
                ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
                ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
                ->join('waktu_ujian', 'waktu_ujian.kode', '=', 'ujian.kode')
                ->where('waktu_ujian.selesai', '!=', 1)
                ->where('waktu_ujian.siswa_id', session()->get('id'))
                ->select(
                    'rum.*',
                    'waktu_ujian.*',
                    'ujian.jenis as jenis_ujian',
                    'ujian.kode as kode_ujian',
                    'merge_ujian.jam',
                    'merge_ujian.menit',
                    'merge_ujian.kode as merge_ujian_kode'
                )
                ->distinct('rum.id')
                ->orderBy('rum.urutan', 'asc')
                // ->orderBy('rum.urutan', 'desc')
                ->first();

            // dd($mergeUjian);

            if (!$mergeUjian) {
                throw new \Exception("Data Merge Ujian tidak ditemukan.");
            }
            // Simulasi ujian
            // dd($mergeUjian->kode);
            $simulasiPg = SimulatorUjianPg::where('kode', $mergeUjian->kode)->get();
            $simulasiVisual = SimulatorUjianVisual::where('kode', $mergeUjian->kode)->get();
            $simulasiEssay = SimulasiUjianEssay::where('kode', $mergeUjian->kode)->get();
            // dd($simulasiVisual);

            // Notifikasi tugas dan ujian
            $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
                ->where('date_send', null)
                ->get();
            $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
                ->where('selesai', null)
                ->get();

            // Intruksi ujian
            $IntruksiUjian = IntruksiUjian::where('kode', $mergeUjian->kode_ujian)->get();
            // dd($mergeUjian->kode_ujian );
            // dd( $IntruksiUjian);
            if (count($simulasiPg) <= 0 && count($simulasiVisual) <= 0 && count($IntruksiUjian) <= 0) {
                // dd($mergeUjian->jenis_ujian);
                if ($mergeUjian->jenis_ujian == 0) {
                    return redirect(url('siswa/ujian/' . $ujian));
                } elseif ($mergeUjian->jenis_ujian == 1) {
                    return redirect(url('siswa/ujian_essay/' . $ujian));
                } elseif ($mergeUjian->jenis_ujian == 2) {
                    return redirect(url('siswa/ujian_kuesioner/' . $ujian));
                } elseif ($mergeUjian->jenis_ujian == 3) {
                    return redirect(url('siswa/ujian_visual/' . $ujian));
                } elseif ($mergeUjian->jenis_ujian == 'Kuesioner') {
                    return redirect(url('siswa/ujian-kuesioner/' . $ujian));
                }
            }
            // dd($simulasiPg);
            // dd($mergeUjian->kode);

            return view('siswa.ujian.merge-ujian-instruksi', [
                'title' => 'Intruksi Ujian',
                'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            ',
                'menu' => [
                    'menu' => 'ujian',
                    'expanded' => 'ujian'
                ],
                'siswa' => Siswa::firstWhere('id', session()->get('id')),
                'notif_tugas' => $notif_tugas,
                'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
                'notif_ujian' => $notif_ujian,
                'mergeUjian' => $mergeUjian,
                'ujian' => $ujian,
                'simulasiPg' => $simulasiPg,
                'simulasiVisual' => $simulasiVisual,
                'IntruksiUjian' => $IntruksiUjian,
                'simulasiEssay' => $simulasiEssay,
                'simulasiKuesioner' => [],
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan dan tampilkan pesan error
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function benner($ujian)
    {


        // $waktuUjian = UjianServiceController::setEndTimeForExam($ujian);

        $mergeUjian = MergeUjian::where('merge_ujian.kode', $ujian)
            ->join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->leftJoin('waktu_ujian', function ($join) use ($ujian) {
                $join->on('waktu_ujian.kode', '=', 'merge_ujian.kode')
                    ->where('waktu_ujian.siswa_id', '=', session()->get('id'));
            })
            ->select(
                'rum.*',
                'waktu_ujian.*',
                'ujian.jenis as jenis_ujian',
                'merge_ujian.jam',
                'merge_ujian.menit',
                'merge_ujian.kode as merge_ujian_kode'
            )
            ->where(function ($query) {
                $query->whereRaw('rum.urutan = waktu_ujian.selesai + 1'); // Tampilkan data urutan = 1 jika tidak ada waktu ujian yang terkait
            })
            ->distinct('rum.id')
            ->orderBy('rum.urutan', 'asc')
            ->first();


        // dd($mergeUjian);

        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();
        return view('siswa.ujian.merge-ujian-slide', [
            'title' => 'Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'mergeUjian' => $mergeUjian,
            'ujian' => $ujian,
        ]);
    }
    public function edit(Ujian $ujian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ujian  $ujian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ujian $ujian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ujian  $ujian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ujian $ujian)
    {
        //
    }

    public function simpan_pg(Request $request)
    {
        $id_detail_ujian = $request->idDetail;
        $id_pg = $request->id_pg;
        $jawaban = $request->jawaban;

        $detail_ujian = DetailUjian::firstWhere('id', $id_detail_ujian);

        if ($jawaban == $detail_ujian->jawaban) {
            $benar = 1;
        } else {
            $benar = 0;
        }

        $data = [
            'jawaban' => $jawaban,
            'benar' => $benar
        ];

        try {
            PgSiswa::where('id', $id_pg)
                ->update($data);
            echo 'jawaban dikirim';
        } catch (\Exception $exeption) {
            echo $exeption->getMessage();
        }
    }
    public function ragu_pg(Request $request)
    {
        PgSiswa::where('id', $request->id_pg)
            ->update(['ragu' => $request->ragu]);
        echo 'checked ragu';
    }
    public function simpan_essay(Request $request)
    {
        $id_detail_ujian = $request->idDetail;
        $id_essay = $request->id_essay;
        $jawaban = $request->jawaban;
        try {
            EssaySiswa::where('id', $id_essay)
                ->update(['jawaban' => $jawaban]);
            echo 'jawaban dikirim';
        } catch (\Exception $exeption) {
            echo $exeption->getMessage();
        }
    }
    public function ragu_essay(Request $request)
    {
        EssaySiswa::where('id', $request->id_essay)
            ->update(['ragu' => $request->ragu]);

        echo 'checked ragu';
    }



    public function uploadSoal(Request $request)
    {

        // Validasi file yang diunggah
        $request->validate([
            'pertanyaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $paths = [];

        // Proses unggah untuk tiap file yang ada di request
        if ($request->hasFile('pertanyaan')) {
            $paths['pertanyaan'] = $request->file('pertanyaan')->store('soal_images');
        }

        for ($i = 1; $i <= 6; $i++) {
            if ($request->hasFile("gambar_pilihan_$i")) {
                $paths["gambar_pilihan_$i"] = $request->file("gambar_pilihan_$i")->store('soal_images');
            }
        }


        // Simpan jawaban benar (bisa di database atau kembalikan respon JSON)
        $paths['jawaban_benar'] = $request->input('jawaban_benar');
        $kode = $request->kode;
        $detail_ujian = [
            'kode' => $kode,
            'soal' => "Pilih gambar yang sama",
            'pg_1' => 'A. ' . $request->file('gambar_pilihan_1')->store('ujian_visual/A', 'public'),
            'pg_2' => 'B. ' . $request->file('gambar_pilihan_2')->store('ujian_visual/B', 'public'),
            'pg_3' => 'C. ' . $request->file('gambar_pilihan_3')->store('ujian_visual/C', 'public'),
            'pg_4' => 'D. ' . $request->file('gambar_pilihan_4')->store('ujian_visual/D', 'public'),
            'pg_5' => 'E. ' . $request->file('gambar_pilihan_5')->store('ujian_visual/E', 'public'),
            'jawaban_1' => $request->jawaban_benar,
            'jawaban_2' => $request->jawaban_benar_2
        ];

        $uj = Ujian::where('kode', $kode)->first();
        if (!$uj) {
            # code...
            $ujian = [
                'kode' => $kode,
                'nama' => $request->nama_ujian,
                'jenis' => 3,
                'guru_id' => session()->get('id'),
                'kelas_id' => $request->kelas,
                'mapel_id' => $request->mapel,
                'jam' => $request->jam,
                'menit' => $request->menit,
                'acak' => $request->acak,
            ];
            Ujian::insert($ujian);
        }


        DetailVisual::insert($detail_ujian);
        return response()->json([
            'message' => 'Soal berhasil diupload',
            'paths' => $paths,
            'request' => $request->all(),
        ], 200);
    }
    public function uploadSoalVisual(Request $request)
    {

        // Validasi file yang diunggah
        $request->validate([
            'pertanyaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $paths = [];

        // Proses unggah untuk tiap file yang ada di request
        if ($request->hasFile('pertanyaan')) {
            $paths['pertanyaan'] = $request->file('pertanyaan')->store('soal_images');
        }

        for ($i = 1; $i <= 6; $i++) {
            if ($request->hasFile("gambar_pilihan_$i")) {
                $paths["gambar_pilihan_$i"] = $request->file("gambar_pilihan_$i")->store('soal_images');
            }
        }


        // Simpan jawaban benar (bisa di database atau kembalikan respon JSON)
        $paths['jawaban_benar'] = $request->input('jawaban_benar');
        $kode = $request->kode;

        $detail_ujian = [
            'kode' => $kode,
            'soal' => "Pilih gambar yang sama",
            'pg_1' => 'A. ' . $request->file('gambar_pilihan_1')->store('ujian_visual/A', 'public'),
            'pg_2' => 'B. ' . $request->file('gambar_pilihan_2')->store('ujian_visual/B', 'public'),
            'pg_3' => 'C. ' . $request->file('gambar_pilihan_3')->store('ujian_visual/C', 'public'),
            'pg_4' => 'D. ' . $request->file('gambar_pilihan_4')->store('ujian_visual/D', 'public'),
            'pg_5' => 'E. ' . $request->file('gambar_pilihan_5')->store('ujian_visual/E', 'public'),
            'jawaban_1' => $request->jawaban_benar,
            'jawaban_2' => $request->jawaban_benar_2
        ];



        $simulasi = SimulatorUjianVisual::where('kode', $kode)->first();
        if ($simulasi) {
            // dd($simulasi);
            SimulatorUjianVisual::whereId($simulasi->id)->update($detail_ujian);
        } else {
            SimulatorUjianVisual::create($detail_ujian);
        }
        DetailVisual::insert($detail_ujian);
        return response()->json([
            'message' => 'Soal berhasil diupload',
            'paths' => $paths,
            'request' => $request->all(),
        ], 200);
    }
}
