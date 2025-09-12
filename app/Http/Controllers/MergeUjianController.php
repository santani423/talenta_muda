<?php

namespace App\Http\Controllers;

use App\Models\BanksoalModel;
use App\Models\Guru;
use App\Models\Gurukelas;
use App\Models\Gurumapel;
use App\Models\Kelas;
use App\Models\MergeUjian;
use App\Models\PgSiswa;
use App\Models\RelasiMergeUjian;
use App\Models\Ujian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MergeUjianController extends Controller
{
    public function index()
    {
        // $merge = MergeUjian::join('relasi_ujian_merge as rum','rum.kode_merge_ujian','=','merge_ujian.kode')->get();
        // dd(MergeUjian::get());
        return view('guru.merge-ujian.index', [
            'title' => 'Data Tes',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'merge_ujian',
                'expanded' => 'merge_ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'merge_ujian' => MergeUjian::join('kelas', 'kelas.id', '=', 'merge_ujian.kelas_id')->get()
        ]);
    }

    public function create(Request $request)
    {

        return view('guru.merge-ujian.create', [
            'title' => 'Tambah Ujian Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
            ',
            'menu' => [
                'menu' => 'merge_ujian',
                'expanded' => 'merge_ujian'
            ],
            'kelas_id' => $request->kelas,
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'ujian' => Ujian::where('guru_id', session()->get('id'))->get(),
            'kelas' => Kelas::whereId($request->kelas)->first()
        ]);
    }

    function store(Request $request)
    {
        // dd($request->all());
        $kode = Str::random(30);
        $MergeUjian = [
            'kode' => $kode,
            'nama' => $request->nama,
            'jenis' => 3,
            'kelas_id' => $request->kelas_id,
            'jam' => 0,
            'menit' => 0,
            'acak' => 0,
        ];
        // dd($request->all());
        $urutan = 1;
        $relasi_merge_ujian = [];
        $ujian_id =  $request->ujian_id;
        foreach ($ujian_id as $index => $ujn_id) {
            $ujian = Ujian::whereId($ujn_id)->first();
            if ($ujian) {

                array_push($relasi_merge_ujian, [
                    'kode_ujian' => $ujian->kode,
                    'kode_merge_ujian' => $kode,
                    'banner' =>  "",
                    'urutan' =>   $urutan,
                    'instruksi_ujian' =>   "",
                ]);
            }
            $index++;
            $urutan++;
        }
        // dd($MergeUjian);
        MergeUjian::insert($MergeUjian);
        // RelasiMergeUjian::insert($relasi_merge_ujian);

        return response()->json([
            'status' => true,
            'message' => 'Merge Ujian berhasil ditambahkan',
            'data' => [
                'kode' => $kode,
                'merge_ujian' => $MergeUjian,
                'relasi_merge_ujian' => $relasi_merge_ujian,
            ]
        ], 201);
    }

    public function relasi_merge_ujian(Request $request)
    {


        try {
            $validated = $request->all();
            // insert sekaligus (batch insert)
            RelasiMergeUjian::insert($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Relasi Merge Ujian berhasil ditambahkan',
                'data'    => $validated
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menambahkan relasi merge ujian',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    function show($code = null)
    {

        $MergeUjianSiswa = MergeUjian::join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', '=', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->join('detail_ujian', 'detail_ujian.kode', '=', 'ujian.kode')

            // Joins untuk siswa dari berbagai tabel
            ->leftJoin('pg_siswa', 'pg_siswa.detail_ujian_id', '=', 'detail_ujian.id')
            ->leftJoin('siswa as siswa_pg', 'siswa_pg.id', '=', 'pg_siswa.siswa_id')

            ->leftJoin('detail_visual', 'detail_visual.kode', '=', 'ujian.kode')
            ->leftJoin('visual_siswa', 'visual_siswa.detail_visual_id', '=', 'detail_visual.id')
            ->leftJoin('siswa as siswa_visual', 'siswa_visual.id', '=', 'visual_siswa.siswa_id')

            ->leftJoin('detail_essay', 'detail_essay.kode', '=', 'ujian.kode')
            ->leftJoin('essay_siswa', 'essay_siswa.detail_ujian_id', '=', 'detail_essay.id')
            ->leftJoin('siswa as siswa_essay', 'siswa_essay.id', '=', 'essay_siswa.siswa_id')

            ->leftJoin('detail_kuisoner', 'detail_kuisoner.kode', '=', 'ujian.kode')
            ->leftJoin('kuesioner_siswa', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->leftJoin('siswa as siswa_kuesioner', 'siswa_kuesioner.id', '=', 'kuesioner_siswa.siswa_id')
            ->where('merge_ujian.kode', $code)
            // Pilih kolom spesifik untuk menghindari konflik
            ->select(
                'merge_ujian.*',
                'siswa_pg.nama_siswa as nama_siswa_pg',
                'siswa_pg.tempat_lahir as tempat_lahir_pg',
                'siswa_pg.tanggal_lahir as tanggal_lahir_pg',
                'siswa_pg.gender as gender_pg',
                'siswa_pg.tempat_lahir as tempat_lahir_pg',
                'siswa_visual.nama_siswa as nama_siswa_visual',
                'siswa_essay.nama_siswa as nama_siswa_essay',
                'siswa_kuesioner.nama_siswa as nama_siswa_kuesioner',

                'siswa_pg.id as id_siswa_pg',
                'siswa_visual.id as id_siswa_visual',
                'siswa_essay.id as id_siswa_essay',
                'siswa_kuesioner.id as id_siswa_kuesioner'
            )

            // Hindari data siswa yang null
            ->where(function ($query) {
                $query->whereNotNull('siswa_pg.nama_siswa')
                    ->orWhereNotNull('siswa_visual.nama_siswa')
                    ->orWhereNotNull('siswa_essay.nama_siswa')
                    ->orWhereNotNull('siswa_kuesioner.nama_siswa');
            })

            // Hindari data duplikat
            ->distinct()
            ->get();





        return view('guru.merge-ujian.show', [
            'title' => 'Data Ujian',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'merge_ujian',
                'expanded' => 'merge_ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'merge_ujians' => MergeUjian::join('kelas', 'kelas.id', '=', 'merge_ujian.kelas_id')->get(),
            'merge_ujian' => MergeUjian::where('merge_ujian.kode', $code)->join('kelas', 'kelas.id', '=', 'merge_ujian.kelas_id')->first(),
            'total_merge_ujian' => MergeUjian::join('relasi_ujian_merge', 'relasi_ujian_merge.kode_merge_ujian', '=', 'merge_ujian.kode')->count(),

            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'ujian' => Ujian::where('ujian.guru_id', session()->get('id'))
                ->where('merge_ujian.kode', $code)
                ->join('relasi_ujian_merge', 'relasi_ujian_merge.kode_ujian', '=', 'ujian.kode')
                ->join('merge_ujian', 'merge_ujian.kode', '=', 'relasi_ujian_merge.kode_merge_ujian')
                ->select('ujian.*')

                ->orderBy('relasi_ujian_merge.urutan', 'asc')
                ->get(),
            'MergeUjianSiswa' => $MergeUjianSiswa
        ]);
    }

    public function edit($kode)
    {

        $merge = MergeUjian::where('kode', $kode)->first();
        $relasi_merge_ujian = RelasiMergeUjian::where('kode_merge_ujian', $kode)->get();
        return view('guru.merge-ujian.edit', [
            'title' => 'Tambah Ujian Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
            ',
            'menu' => [
                'menu' => 'merge_ujian',
                'expanded' => 'merge_ujian'
            ],
            'kelas_id' => $merge->kelas_id,
            'merge' => $merge,
            'relasi_merge_ujian' => $relasi_merge_ujian,
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'ujian' => Ujian::where('guru_id', session()->get('id'))->get(),
            'kelas' => Kelas::whereId($merge->kelas_id)->first()
        ]);
    }


    function update(Request $request, $id)
    {

        $MergeUjian = [
            'nama' => $request->nama,
            'jam' => $request->jam,
            'menit' => $request->menit,
        ];
        // dd($request->all());
        $urutan = 1;
        $idRelasiMergeUjian =  $request->idRelasiMergeUjian;
        foreach ($idRelasiMergeUjian as $index => $idRelasiMerge) {
            $ujian = Ujian::whereId($request->ujian_id[$index])->first();
            $date = RelasiMergeUjian::whereId($idRelasiMerge)->first();
            if ($ujian) {
                // dd($date->kode);
                $bannerPath =   $date->banner;
                $instruksiUjianPath =   $date->instruksi_ujian;
                // if ($request->hasFile('banner.' . $index)) {
                //     $bannerFile = $request->file('banner.' . $index);
                //     // Save banner to storage and get the path
                //     $bannerPath = $bannerFile->store('marge_ujian/banners', 'public'); // Store in 'storage/app/public/banners' 
                // }
                // if ($request->hasFile('instruksi_ujian.' . $index)) {
                //     $instruksi_ujian = $request->file('instruksi_ujian.' . $index);
                //     // Save banner to storage and get the path 
                //     $instruksiUjianPath = $instruksi_ujian->store('marge_ujian/instruksi_ujian', 'public'); // Store in 'storage/app/public/instruksi_ujian'
                // }

                $date->update([
                    'kode_ujian' => $ujian->kode,
                    // 'banner' =>   $bannerPath,
                    // 'instruksi_ujian' =>   $instruksiUjianPath,
                ]);
            }
            $index++;
            $urutan++;
        }
        // dd($relasi_merge_ujian);
        $merge = MergeUjian::where('id', $id)->first();
        MergeUjian::whereId($id)->update($MergeUjian);

        // dd($id);
        return redirect(url('guru/merge_ujian/' . $merge->kode))->with('pesan', "
        <script>
            swal({
                    title: 'Success!',
                    text: 'Ubah Merge Ujian',
                    type: 'success',
                    padding: '2em'
                })
        </script>
    ");
    }

    public function showUjian(Ujian $ujian)
    {
        // dd($ujian->detailujian);
        // $relasiUjian = RelasiMergeUjian::where('kode_ujian',$ujian->kode)->first();
        // $mergeUjian = MergeUjian::where('kode',$relasiUjian->kode_merge_ujian)->first();
        // dd($relasiUjian);


        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs

        foreach ($ujian->detailujian as $key => $detailujian) {
        }
        // Get total number of questions for the current ujian
        $total_soal_pg = $ujian->detailujian->count();

        $pgUjian = PgSiswa::join('detail_ujian as du', 'du.id', '=', 'pg_siswa.detail_ujian_id')
            ->join('siswa', 'siswa.id', '=', 'pg_siswa.siswa_id')
            ->where('du.kode', $ujian->kode)
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
        // Now $results contains unique entries for each student
        // dd($results); // Output the array to check the final result







        // return false;
        return view('guru.ujian.show', [
            'title' => 'Detail Ujian Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'ujian' => $ujian,
            'results' => $results,
        ]);
    }
}
