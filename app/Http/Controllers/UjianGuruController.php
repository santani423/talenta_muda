<?php

namespace App\Http\Controllers;

use App\Exports\EssayExport;
use App\Exports\PgExport;
use App\Models\Guru;
use App\Models\Ujian;
use App\Models\Gurukelas;
use App\Models\Gurumapel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\UjianServiceController;
use App\Imports\PgImport;
use App\Mail\NotifUjian;
use App\Models\BanksoalModel;
use App\Models\DetailbankessayModel;
use App\Models\DetailbankpgModel;
use App\Models\DetailEssay;
use App\Models\DetailJawabanKuesioner;
use App\Models\DetailKuisoner;
use App\Models\DetailUjian;
use App\Models\DetailVisual;
use App\Models\EmailSettings;
use App\Models\EssaySiswa;
use App\Models\IntruksiUjian;
use App\Models\JenisJawabanKuesioner;
use App\Models\KuesionerSiswa;
use App\Models\MergeUjian;
use App\Models\PgSiswa;
use App\Models\RelasiMergeUjian;
use App\Models\JawabanEssay;
use App\Models\SimulatorUjianPg;
use App\Models\SimulatorUjianVisual;
use App\Models\Siswa;
use App\Models\VisualSiswa;
use App\Models\WaktuUjian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UjianGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('guru.ujian.index', [
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
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'ujian' => Ujian::where('guru_id', session()->get('id'))->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru.ujian.create', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' => Str::random(30),
        ]);
    }

    public function create_visual()
    {
        return view('guru.ujian.create_visual', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' => Str::random(30),
        ]);
    }

    public function create_visual_ujian_simulator($id)
    {
        $ujian = Ujian::whereId($id)->first();
        // dd($ujian->simulasiVisual);
        return view('guru.ujian.create_visual_ujian_simulator', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' =>  $ujian->kode,
            'detailVisual' => $ujian->detailVisual,
            'ujianData' => $ujian,
            'simulasiVisual' => $ujian->simulasiVisual,
        ]);
    }

    function store_visual_ujian_simulator_copy(Request $request, $id)
    {
        try {
            // Ambil semua data dari tabel detail_ujian
            // return back()->with('success', 'Simulasi Ujian berhasil dibuat.');
            $detailUjianData = DetailVisual::whereId($request->soal_choice)->first();
            $ujian = Ujian::whereId($id)->first();
            $simulasi = SimulatorUjianVisual::where('kode', $ujian->kode)->first();
            $data = [
                'kode'   => $ujian->kode,
                'soal'   => $detailUjianData->soal,
                'pg_1'   => $detailUjianData->pg_1,
                'pg_2'   => $detailUjianData->pg_2,
                'pg_3'   => $detailUjianData->pg_3,
                'pg_4'   => $detailUjianData->pg_4,
                'pg_5'   => $detailUjianData->pg_5,
                'pg_6'   => '-',
                'jawaban_1' => $detailUjianData->jawaban_1,
                'jawaban_2' => $detailUjianData->jawaban_2,
            ];
            if ($simulasi) {
                // dd($simulasi);
                SimulatorUjianVisual::whereId($simulasi->id)->update($data);
            } else {
                SimulatorUjianVisual::create($data);
            }

            // Siapkan array untuk data yang akan diinsert ke simulai_ujan
            return back()->with('success', 'Simulasi Ujian berhasil dibuat.');
        } catch (\Throwable $e) {
            Log::error('Error duplicating data: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat Simulasi Ujian. Periksa log untuk detail lebih lanjut.');
        }
    }

    public function edit_visual(Ujian $ujian)
    {

        $soal  = [
            ['option' => 'A', 'image_path' =>  'pg_1'],
            ['option' => 'B', 'image_path' =>  'pg_2'],
            ['option' => 'C', 'image_path' =>  'pg_3'],
            ['option' => 'D', 'image_path' =>  'pg_4'],
            ['option' => 'E', 'image_path' =>  'pg_5']
        ];
        // dd($ujian);
        return view('guru.ujian.edit_visual', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' => Str::random(30),
            'ujian' => $ujian,
            'soalPilihan' => $soal,
        ]);
    }

    public function create_essay(Request $request)
    {
        switch ($request->type_kunci_jawaban) {
            case 'number':
                $jumlah_kunci_jawaban = 1;
                break;
            case 'text':
                $jumlah_kunci_jawaban = 3;
                break;

            default:
                $jumlah_kunci_jawaban = 0;
                break;
        }

        return view('guru.ujian.create-essay', [
            'title' => 'Tambah Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'jumlah_kunci_jawaban' => $jumlah_kunci_jawaban,
            'type_kunci_jawaban' => $request->type_kunci_jawaban ?? 'text',
        ]);
    }

    public function edit_essay(Ujian $ujian)
    {
        // dd($ujian);

        return view('guru.ujian.edit-essay', [
            'title' => 'Tambah Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'ujian' => $ujian
        ]);
    }


    public function show_kuesioner(Ujian $ujian)
    {
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

        // dd($results);
        return view('guru.ujian.show-kuesioner-siswa', [
            'title' => 'Detail Ujian Essay',
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



    function kuesioner_siswa($kode, $siswa_id)
    {

        $ujian_siswa = EssaySiswa::where('kode', $kode)
            ->where('siswa_id', $siswa_id)
            ->get();

        $detail_siswa = DetailKuisoner::join('kuesioner_siswa', 'kuesioner_siswa.detail_kuisoner', '=', 'detail_kuisoner.id')
            ->join('detail_jawaban_kuesioner', 'detail_jawaban_kuesioner.id', '=', 'kuesioner_siswa.detail_jawaban_kuesioner_id')
            ->where('detail_kuisoner.kode', $kode)
            ->where('kuesioner_siswa.siswa_id', $siswa_id)
            // ->select('detail_kuisoner.*',)
            ->get()
            ->chunk(10)
            ->toArray();
        // dd( $detail_siswa);

        return view('guru.ujian.show-kuesioner', [
            'title' => 'Detail Ujian Essay Siswa',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'ujian_siswa' => $ujian_siswa,
            'detail_siswa' => $detail_siswa,
            'ujian' => Ujian::firstWhere('kode', $kode),
            'siswa' => Siswa::firstWhere('id', $siswa_id)
        ]);
    }

    public function create_kuesioner()
    {
        return view('guru.ujian.create-kuesioner', [
            'title' => 'Tambah Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'jenis_kuesioner' => JenisJawabanKuesioner::get()
        ]);
    }
    public function edit_kuesioner(Ujian $ujian)
    {
        //  dd($ujian->detailKuisoner);
        return view('guru.ujian.edit-kuesioner', [
            'title' => 'Tambah Ujian Essay',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'jenis_kuesioner' => JenisJawabanKuesioner::get(),
            'ujian' => $ujian
        ]);
    }

    function store_kuesioner(Request $request)
    {
        // dd($request->all());
        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->nama,
            'jenis' => 2,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->kelas,
            'mapel_id' => $request->mapel,
            'jam' => $request->jam,
            'menit' => $request->menit,
            'acak' => $request->acak,
        ];

        $detail_kuesoner = [];
        $index = 0;
        $kusioner =  $request->kusioner;
        foreach ($kusioner as $kus) {
            array_push($detail_kuesoner, [
                'kode' => $kode,
                'jenis_jawaban_kuesioner_id' => $request->jenis_kuesoner[$index],
                'soal' => $kus
            ]);

            $index++;
        }

        Ujian::insert($ujian);
        DetailKuisoner::insert($detail_kuesoner);
        return redirect('/guru/ujian_kuesioner/' . $kode)->with('pesan', "
        <script>
            swal({
                title: 'Success!',
                text: 'ujian sudah di posting!',
                type: 'success',
                padding: '2em'
            })
        </script>
    ");
    }

    function update_kuesioner(Request $request, $id)
    {
        // dd($request);
        $ujian = [
            'nama' => $request->nama,
            'kelas_id' => $request->kelas,
            'mapel_id' => $request->mapel,
            'menit' => $request->b_menit,
            'jam' => $request->b_jam,
        ];

        $index = 0;
        $kusioner =  $request->kusonerId;
        $ujianData = Ujian::whereId($id)->first();
        foreach ($kusioner as $kus) {


            $data =   DetailKuisoner::whereId($kus)->first();

            if ($data) {
                DetailKuisoner::whereId($kus)->update([
                    'jenis_jawaban_kuesioner_id' => $request->jenis_kuesoner[$index],
                    'soal' => $request->kusioner[$index]
                ]);
            } else {
                DetailKuisoner::create([
                    'jenis_jawaban_kuesioner_id' => $request->jenis_kuesoner[$index],
                    'soal' => $request->kusioner[$index],
                    'kode' => $ujianData->kode
                ]);
            }


            $index++;
        }

        Ujian::whereId($id)->update($ujian);

        return redirect('/guru/ujian_kuesioner/' . $ujianData->kode)->with('pesan', "
        <script>
            swal({
                title: 'Success!',
                text: 'ujian sudah di posting!',
                type: 'success',
                padding: '2em'
            })
        </script>
    ");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // Validasi file yang diunggah
        $request->validate([
            'pertanyaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_6' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        $ujianData = [
            'kode' => $kode,
            'nama' => $request->nama_ujian,
            'jenis' => 0,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->kelas,
            'mapel_id' => $request->mapel,
            'jam' => $request->jam,
            'menit' => $request->menit,
            'acak' => $request->acak,
        ];


        $detail_ujian = [
            'kode' => $kode,
            'soal' => $request->file('pertanyaan')->store('ujian_pg/pertanyaan', 'public'),
            'pg_1' => 'A. ' . $request->file('gambar_pilihan_1')->store('ujian_pg/A', 'public'),
            'pg_2' => 'B. ' . $request->file('gambar_pilihan_2')->store('ujian_pg/B', 'public'),
            'pg_3' => 'C. ' . $request->file('gambar_pilihan_3')->store('ujian_pg/C', 'public'),
            'pg_4' => 'D. ' . $request->file('gambar_pilihan_4')->store('ujian_pg/D', 'public'),
            'pg_5' => 'E. ' . $request->file('gambar_pilihan_5')->store('ujian_pg/E', 'public'),
            'pg_6' => 'F. ' . $request->file('gambar_pilihan_6')->store('ujian_pg/F', 'public'),
            'jawaban' => $request->jawaban_benar
        ];

        $uj = Ujian::where('kode', $kode)->first();



        if (!$uj) {
            Ujian::create($ujianData);
        }


        DetailUjian::insert($detail_ujian);
        return response()->json([
            'message' => 'Soal berhasil diupload',
            'paths' => $paths,
            'request' => $request->all(),
        ], 200);
    }
    public function store_ujian_simulator(Request $request)
    {

        // Validasi file yang diunggah
        $request->validate([
            'pertanyaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pilihan_6' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $paths = [];



        // Simpan jawaban benar (bisa di database atau kembalikan respon JSON)
        $paths['jawaban_benar'] = $request->input('jawaban_benar');
        $kode = $request->kode;
        $detail_ujian = [
            'kode' => $kode,
            'soal' => $request->file('pertanyaan')->store('ujian_pg/pertanyaan', 'public'),
            'pg_1' => 'A. ' . $request->file('gambar_pilihan_1')->store('ujian_pg/A', 'public'),
            'pg_2' => 'B. ' . $request->file('gambar_pilihan_2')->store('ujian_pg/B', 'public'),
            'pg_3' => 'C. ' . $request->file('gambar_pilihan_3')->store('ujian_pg/C', 'public'),
            'pg_4' => 'D. ' . $request->file('gambar_pilihan_4')->store('ujian_pg/D', 'public'),
            'pg_5' => 'E. ' . $request->file('gambar_pilihan_5')->store('ujian_pg/E', 'public'),
            'pg_6' => 'F. ' . $request->file('gambar_pilihan_6')->store('ujian_pg/F', 'public'),
            'jawaban' => $request->jawaban_benar
        ];

        return response()->json([
            'message' => 'Soal berhasil diupload',
            // 'paths' => $paths,
            'request' => $request->all(),
        ], 200);

        $simulasi = SimulatorUjianPg::where('kode', $kode)->first();

        if ($simulasi) {
            $simulasi->update($detail_ujian);
        } else {
            SimulatorUjianPg::create($detail_ujian);
        }

        return response()->json([
            'message' => 'Soal berhasil diupload',
            'paths' => $paths,
            'request' => $request->all(),
        ], 200);
    }
    public function pg_excel(Request $request)
    {
        $siswa = Siswa::where('kelas_id', $request->e_kelas)->get();
        if ($siswa->count() == 0) {
            return redirect('/guru/ujian/create')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'belum ada siswa di kelas tersebut!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }

        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->e_nama_ujian,
            'jenis' => 0,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->e_kelas,
            'mapel_id' => $request->e_mapel,
            'jam' => $request->e_jam,
            'menit' => $request->e_menit,
            'acak' => $request->e_acak,
        ];

        $email_siswa = '';
        $waktu_ujian = [];
        foreach ($siswa as $s) {
            $email_siswa .= $s->email . ',';

            array_push($waktu_ujian, [
                'kode' => $kode,
                'siswa_id' => $s->id
            ]);
        }

        $email_siswa = Str::replaceLast(',', '', $email_siswa);
        $email_siswa = explode(',', $email_siswa);

        $email_settings = EmailSettings::first();
        if ($email_settings->notif_ujian == '1') {
            $details = [
                'nama_guru' => session()->get('nama_guru'),
                'nama_ujian' => $request->e_nama_ujian,
                'jam' => $request->e_jam,
                'menit' => $request->e_menit,
            ];
            Mail::to($email_siswa)->send(new NotifUjian($details));
        }

        Ujian::insert($ujian);
        Excel::import(new PgImport($kode), $request->excel);
        WaktuUjian::insert($waktu_ujian);

        return redirect('/guru/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function store_bank_pg(Request $request)
    {
        $siswa = Siswa::where('kelas_id', $request->b_kelas)->get();
        if ($siswa->count() == 0) {
            return redirect('/guru/ujian/create')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'belum ada siswa di kelas tersebut!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }

        $detail_bank_soal = DetailbankpgModel::where('kode', $request->kode_bank)->get();

        if ($detail_bank_soal->count() == 0) {
            return redirect('/guru/ujian/create')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'Data Bank soal tidak ditemukan!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }

        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->b_nama_ujian,
            'jenis' => 0,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->b_kelas,
            'mapel_id' => $request->b_mapel,
            'jam' => $request->b_jam,
            'menit' => $request->b_menit,
            'acak' => $request->b_acak,
        ];

        $detail_ujian = [];
        $index = 0;
        foreach ($detail_bank_soal as $soal) {
            array_push($detail_ujian, [
                'kode' => $kode,
                'soal' => $soal->soal,
                'pg_1' => $soal->pg_1,
                'pg_2' => $soal->pg_2,
                'pg_3' => $soal->pg_3,
                'pg_4' => $soal->pg_4,
                'pg_5' => $soal->pg_5,
                'jawaban' => $soal->jawaban
            ]);

            $index++;
        }

        $email_siswa = '';
        $waktu_ujian = [];
        foreach ($siswa as $s) {
            $email_siswa .= $s->email . ',';

            array_push($waktu_ujian, [
                'kode' => $kode,
                'siswa_id' => $s->id
            ]);
        }

        $email_siswa = Str::replaceLast(',', '', $email_siswa);
        $email_siswa = explode(',', $email_siswa);

        $email_settings = EmailSettings::first();
        if ($email_settings->notif_ujian == '1') {
            $details = [
                'nama_guru' => session()->get('nama_guru'),
                'nama_ujian' => $request->b_nama_ujian,
                'jam' => $request->b_jam,
                'menit' => $request->b_menit,
            ];
            Mail::to($email_siswa)->send(new NotifUjian($details));
        }


        Ujian::insert($ujian);
        DetailUjian::insert($detail_ujian);
        WaktuUjian::insert($waktu_ujian);

        return redirect('/guru/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function store_essay(Request $request)
    {

        $siswa = Siswa::where('kelas_id', $request->kelas)->get();
        // if ($siswa->count() == 0) {
        //     return redirect('/guru/ujian_essay')->with('pesan', "
        //         <script>
        //             swal({
        //                 title: 'Error!',
        //                 text: 'belum ada siswa di kelas tersebut!',
        //                 type: 'error',
        //                 padding: '2em'
        //             })
        //         </script>
        //     ")->withInput();
        // }

        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->nama,
            'jenis' => 1,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->kelas,
            'mapel_id' => $request->mapel,
            'jam' => $request->jam,
            'menit' => $request->menit,

        ];

        $detail_ujian = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_ujian, [
                'kode' => $kode,
                'soal' => $soal
            ]);

            $index++;
        }

        $email_siswa = '';
        $waktu_ujian = [];
        foreach ($siswa as $s) {
            $email_siswa .= $s->email . ',';

            array_push($waktu_ujian, [
                'kode' => $kode,
                'siswa_id' => $s->id
            ]);
        }

        $email_siswa = Str::replaceLast(',', '', $email_siswa);
        $email_siswa = explode(',', $email_siswa);
        // dd($request->all());
        $email_settings = EmailSettings::first();
        if ($email_settings->notif_ujian == '1') {
            $details = [
                'nama_guru' => session()->get('nama_guru'),
                'nama_ujian' => $request->nama,
                'jam' => $request->jam,
                'menit' => $request->menit,
                'type_kunci_jawaban' => $request->type_kunci_jawaban,
            ];
            Mail::to($email_siswa)->send(new NotifUjian($details));
        }

        Ujian::insert($ujian);
        DetailEssay::insert($detail_ujian);
        WaktuUjian::insert($waktu_ujian);
        $DetailEssay = DetailEssay::where('kode', $kode)->get();
        $jawaban_essay = [];
        // WaktuUjian::insert($waktu_ujian);


        foreach ($DetailEssay as $key => $value) {
            // Increment key by 1 for display purposes
            $displayKey = $key + 1;

            // Loop through jawaban to find matching answers
            foreach ($request->jawaban as $jawabanKey => $jawaban) {
                // Check if the jawabanKey matches the expected pattern for the current soal
                $expectedKeyPrefix = 'soal-' . $displayKey . '-jawaban-';

                if (strpos($jawabanKey, $expectedKeyPrefix) === 0) {
                    // Add the matching jawaban to the $jawaban_essay array
                    $jawaban_essay[] = [
                        'detail_essay_id' => $value->id,
                        'jawaban' => $jawaban, // Store the actual jawaban value
                        'nilai' => $request->nilai[$jawabanKey] // Add the score for the answer
                    ];
                }
            }
        }


        JawabanEssay::insert($jawaban_essay);



        return redirect('/guru/ujian_essay/' . $kode)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function update_essay(Request $request, $id)
    {




        $ujianUpdare = [
            'nama' => $request->nama,
            'kelas_id' => $request->kelas,
            'mapel_id' => $request->mapel,
            'jam' => $request->b_jam,
            'menit' => $request->b_menit,
        ];


        $index = 0;
        $essayId =  $request->essayId;
        $ujian = Ujian::whereId($id)->first();
        foreach ($essayId as $key => $soalId) {



            $data =  DetailEssay::whereId($soalId)->first();
            if ($data) {
                DetailEssay::whereId($soalId)->update([
                    'soal' => $request->soal[$key]
                ]);
                JawabanEssay::where('detail_essay_id', $soalId)->delete();
            } else {
                DetailEssay::create([
                    'kode' => $ujian->kode,
                    'soal' => $request->soal[$key]
                ]);
            }


            $index++;
        }


        $ujian->update($ujianUpdare);

        $DetailEssay = DetailEssay::where('kode', $ujian->kode)->get();
        $jawaban_essay = [];
        // WaktuUjian::insert($waktu_ujian);


        foreach ($DetailEssay as $key => $value) {
            // Increment key by 1 for display purposes
            $displayKey = $key + 1;

            // Loop through jawaban to find matching answers
            foreach ($request->jawaban as $jawabanKey => $jawaban) {
                // Check if the jawabanKey matches the expected pattern for the current soal
                $expectedKeyPrefix = 'soal-' . $displayKey . '-jawaban-';

                if (strpos($jawabanKey, $expectedKeyPrefix) === 0) {
                    // Add the matching jawaban to the $jawaban_essay array
                    $jawaban_essay[] = [
                        'detail_essay_id' => $value->id,
                        'jawaban' => $jawaban, // Store the actual jawaban value
                        'nilai' => $request->nilai[$jawabanKey] // Add the score for the answer
                    ];
                }
            }
        }


        JawabanEssay::insert($jawaban_essay);

        // dd($ujian);
        return redirect('/guru/ujian_essay/' . $ujian->kode)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function store_visual(Request $request)
    {


        $siswa = Siswa::where('kelas_id', $request->kelas)->get();

        if ($siswa->count() == 0) {
            return redirect('/guru/ujian_visual')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'belum ada siswa di kelas tersebut!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }

        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->nama,
            'jenis' => 3,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->kelas,
            'mapel_id' => $request->mapel,
            'jam' => 0,
            'menit' => 0,
            'acak' => $request->acak,
        ];

        $detail_ujian = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_ujian, [
                'kode' => $kode,
                'soal' => $soal,
                'pg_1' => $request->file('pg_1')[$index]->store('ujian_visual/A', 'public'),
                'pg_2' => $request->file('pg_2')[$index]->store('ujian_visual/B', 'public'),
                'pg_3' => $request->file('pg_3')[$index]->store('ujian_visual/C', 'public'),
                'pg_4' => $request->file('pg_4')[$index]->store('ujian_visual/D', 'public'),
                'pg_5' => $request->file('pg_5')[$index]->store('ujian_visual/E', 'public'),
                'pg_6' => $request->file('pg_6')[$index]->store('ujian_visual/F', 'public'),
                'jawaban_1' => $request->jawaban[$index],
                'jawaban_2' => $request->jawaban2[$index]
            ]);

            $index++;
        }

        $email_siswa = '';
        $waktu_ujian = [];
        // foreach ($siswa as $s) {
        //     $email_siswa .= $s->email . ',';

        //     array_push($waktu_ujian, [
        //         'kode' => $kode,
        //         'siswa_id' => $s->id
        //     ]);
        // }

        // $email_siswa = Str::replaceLast(',', '', $email_siswa);
        // $email_siswa = explode(',', $email_siswa);

        // $email_settings = EmailSettings::first();
        // if ($email_settings->notif_ujian == '1') {
        //     $details = [
        //         'nama_guru' => session()->get('nama_guru'),
        //         'nama_ujian' => $request->nama,
        //         'jam' => $request->jam,
        //         'menit' => $request->menit,
        //     ];
        //     Mail::to($email_siswa)->send(new NotifUjian($details));
        // }


        Ujian::insert($ujian);
        DetailVisual::insert($detail_ujian);
        // WaktuUjian::insert($waktu_ujian);

        return redirect('/guru/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    function update_visual(Request $request)
    {
        // Fetch and update the main Ujian record
        $uj = Ujian::where('id', $request->id_ujian)->first();
        if ($uj) {
            $ujianData = [
                'nama' => $request->nama_ujian,
                'kelas_id' => $request->kelas,
                'mapel_id' => $request->mapel,
                'jam' => $request->jam,
                'menit' => $request->menit,
            ];
            Ujian::where('id', $request->id_ujian)->update($ujianData);
        }

        // Prepare paths array for storing file paths
        $pathsA = $pathsB = $pathsC = $pathsD = $pathsE = null;

        // Fetch existing DetailVisual or initialize empty
        $DetailUjian = DetailVisual::where('id', $request->detailUjianId)->first();

        if ($DetailUjian) {
            $pathsA = $DetailUjian->pg_1;
            $pathsB = $DetailUjian->pg_2;
            $pathsC = $DetailUjian->pg_3;
            $pathsD = $DetailUjian->pg_4;
            $pathsE = $DetailUjian->pg_5;
        }

        // Handle base64-encoded image in the 'pertanyaan' field
        foreach ($request->gambar_pilihan as $key => $gambar_pilihan) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $gambar_pilihan['imgData']));
            if ($imageData !== false) {
                $filePath = public_path('ujian_visual');
                $fileName = uniqid() . '.png';
                $fullPath = $filePath . '/' . $fileName;

                // Ensure the directory exists
                if (!file_exists($filePath)) {
                    mkdir($filePath, 0755, true);
                }

                // Save the decoded image
                file_put_contents($fullPath, $imageData);

                // Assign the path based on the name
                if ($gambar_pilihan['namegambar'] == 'A') {
                    $pathsA = 'A. ' . 'ujian_visual/' . $fileName;
                } elseif ($gambar_pilihan['namegambar'] == 'B') {
                    $pathsB = 'B. ' . 'ujian_visual/' . $fileName;
                } elseif ($gambar_pilihan['namegambar'] == 'C') {
                    $pathsC = 'C. ' . 'ujian_visual/' . $fileName;
                } elseif ($gambar_pilihan['namegambar'] == 'D') {
                    $pathsD = 'D. ' . 'ujian_visual/' . $fileName;
                } elseif ($gambar_pilihan['namegambar'] == 'E') {
                    $pathsE = 'E. ' . 'ujian_visual/' . $fileName;
                }
            }
        }

        // Prepare detail data
        $detail_ujian = [
            'pg_1' => $pathsA,
            'pg_2' => $pathsB,
            'pg_3' => $pathsC,
            'pg_4' => $pathsD,
            'pg_5' => $pathsE,
            'jawaban_1' => $request->jawaban_benar_1,
            'jawaban_2' => $request->jawaban_benar_2,
            'kode' => $uj->kode,
        ];

        // Update or create DetailVisual
        if ($DetailUjian) {
            DetailVisual::where('id', $request->detailUjianId)->update($detail_ujian);
        } else {
            DetailVisual::create($detail_ujian);
        }

        // Final JSON response
        return response()->json([
            'message' => 'Soal berhasil diupload',
            'data' => $uj,
            'detail_ujian' => $detail_ujian,
            'request' => $request->all(),
        ], 200);
    }


    public function store_bank_essay(Request $request)
    {
        // dd($request);
        $siswa = Siswa::where('kelas_id', $request->b_kelas)->get();
        if ($siswa->count() == 0) {
            return redirect('/guru/ujian_essay')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'belum ada siswa di kelas tersebut!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }

        $detail_bank_soal = DetailbankessayModel::where('kode', $request->kode_bank)->get();

        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->b_nama_ujian,
            'jenis' => 1,
            'guru_id' => session()->get('id'),
            'kelas_id' => $request->b_kelas,
            'mapel_id' => $request->b_mapel,
            'jam' => $request->b_jam,
            'menit' => $request->b_menit,

        ];

        $detail_ujian = [];
        $index = 0;
        foreach ($detail_bank_soal as $soal) {
            array_push($detail_ujian, [
                'kode' => $kode,
                'soal' => $soal->soal
            ]);

            $index++;
        }

        $email_siswa = '';
        $waktu_ujian = [];
        foreach ($siswa as $s) {
            $email_siswa .= $s->email . ',';

            array_push($waktu_ujian, [
                'kode' => $kode,
                'siswa_id' => $s->id
            ]);
        }

        $email_siswa = Str::replaceLast(',', '', $email_siswa);
        $email_siswa = explode(',', $email_siswa);

        $email_settings = EmailSettings::first();
        if ($email_settings->notif_ujian == '1') {
            $details = [
                'nama_guru' => session()->get('nama_guru'),
                'nama_ujian' => $request->b_nama_ujian,
                'jam' => $request->b_jam,
                'menit' => $request->b_menit,
            ];
            Mail::to($email_siswa)->send(new NotifUjian($details));
        }

        Ujian::insert($ujian);
        DetailEssay::insert($detail_ujian);
        WaktuUjian::insert($waktu_ujian);

        return redirect('/guru/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
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
    public function show(Ujian $ujian)
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
    public function show_visual(Ujian $ujian)
    {



        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs

        foreach ($ujian->detailVisual as $key => $detailVisual) {
        }
        // Get total number of questions for the current ujian
        $total_soal_pg = $ujian->detailVisual->count();
        $visualUjian = VisualSiswa::join('detail_visual as dv', 'dv.id', '=', 'visual_siswa.detail_visual_id')
            ->join('siswa', 'siswa.id', '=', 'visual_siswa.siswa_id')
            ->where('dv.kode', $ujian->kode)
            ->select(
            'siswa.id as siswa_id',
            'siswa.nama_siswa as siswa_nama',
            'visual_siswa.jawaban_1 as jawaban_siswa_1',
            'visual_siswa.jawaban_2 as jawaban_siswa_2',
            'dv.jawaban_1 as jawaban_dv_1',
            'dv.jawaban_2 as jawaban_dv_2',
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
            ->groupBy('siswa.id', 'siswa.nama_siswa', 'visual_siswa.jawaban_1', 'visual_siswa.jawaban_2', 'dv.jawaban_1', 'dv.jawaban_2')
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
        return view('guru.ujian.show_visual', [
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
    public function pg_siswa($kode, $siswa_id)
    {
        $ujian_siswa = PgSiswa::where('kode', $kode)
            ->where('siswa_id', $siswa_id)
            ->get();
        return view('guru.ujian.show-siswa', [
            'title' => 'Detail Ujian Siswa',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'ujian_siswa' => $ujian_siswa,
            'ujian' => Ujian::firstWhere('kode', $kode),
            'siswa' => Siswa::firstWhere('id', $siswa_id)
        ]);
    }

    public function show_essay(Ujian $ujian)
    {
        $results = []; // Initialize an array to store the results
        $processedSiswaIds = []; // Array to keep track of processed siswa IDs

        $pgUjian = EssaySiswa::join('detail_essay as du', 'du.id', '=', 'essay_siswa.detail_ujian_id')
            ->join('siswa', 'siswa.id', '=', 'essay_siswa.siswa_id')
            ->where('essay_siswa.kode', $ujian->kode)
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama_siswa as siswa_nama',
                'essay_siswa.kode as kode_ujian',
                DB::raw("SUM(essay_siswa.nilai) as total_nilai"), // Sum of nilai
                DB::raw("COUNT(essay_siswa.nilai) as jumlah_dijawab"), // Count of answered questions
                DB::raw("COUNT(du.id) - COUNT(essay_siswa.nilai) as jumlah_tidak_dijawab") // Total questions - answered questions
            )
            ->groupBy('siswa.id', 'siswa.nama_siswa', 'essay_siswa.kode')
            ->get();

        foreach ($pgUjian as $value) {
            // Check if this student has already been processed
            if (!in_array($value->siswa_id, $processedSiswaIds)) {
                // Calculate the total score based on the characters in the essay answers
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
        return view('guru.ujian.show-essay', [
            'title' => 'Detail Ujian Essay',
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
    public function essay_siswa($kode, $siswa_id)
    {
        $ujian_siswa = EssaySiswa::where('kode', $kode)
            ->where('siswa_id', $siswa_id)
            ->get();
        return view('guru.ujian.show-essay-siswa', [
            'title' => 'Detail Ujian Essay Siswa',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'ujian_siswa' => $ujian_siswa,
            'ujian' => Ujian::firstWhere('kode', $kode),
            'siswa' => Siswa::firstWhere('id', $siswa_id)
        ]);
    }
    public function nilai_essay(Request $request)
    {
        EssaySiswa::where('id', $request->id)
            ->update(['nilai' => $request->nilai]);

        return 'berhasil dinilai';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ujian  $ujian
     * @return \Illuminate\Http\Response
     */
    public function edit(Ujian $ujian)
    {
        // dd($ujian);

        $soal  = [
            ['option' => 'A', 'image_path' =>  'pg_1'],
            ['option' => 'B', 'image_path' =>  'pg_2'],
            ['option' => 'C', 'image_path' =>  'pg_3'],
            ['option' => 'D', 'image_path' =>  'pg_4'],
            ['option' => 'E', 'image_path' =>  'pg_5'],
            ['option' => 'F', 'image_path' =>  'pg_6']
        ];

        return view('guru.ujian.edit', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' => Str::random(30),
            'ujian' => $ujian,
            'soalPilihan' => $soal,
        ]);
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

        // Fetch and update the main Ujian record
        $uj = Ujian::where('id', $request->id_ujian)->first();

        if ($uj) {
            $ujianData = [
                'nama' => $request->nama_ujian,
                'kelas_id' => $request->kelas,
                'mapel_id' => $request->mapel,
                'menit' => $request->menit,
                'jam' => $request->jam,
            ];

            Ujian::where('id', $request->id_ujian)->update($ujianData);
            return response()->json([
                'message' => 'Soal berhasil diupload',
                'request' => $request->all()
            ], 200);
        }

        // Handle DetailUjian
        $DetailUjian = DetailUjian::where('id', $request->detailUjianId)->first();

        // Prepare variables for soal and pilihan ganda
        $pertanyaan = $DetailUjian ? $DetailUjian->soal : null;
        $pathsA = $DetailUjian ? $DetailUjian->pg_1 : null;
        $pathsB = $DetailUjian ? $DetailUjian->pg_2 : null;
        $pathsC = $DetailUjian ? $DetailUjian->pg_3 : null;
        $pathsD = $DetailUjian ? $DetailUjian->pg_4 : null;
        $pathsE = $DetailUjian ? $DetailUjian->pg_5 : null;
        $pathsF = $DetailUjian ? $DetailUjian->pg_6 : null;

        // Handle base64-encoded image in 'pertanyaan'
        $base64Image = $request->pertanyaan;
        if ($base64Image) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            if ($imageData !== false) {
                $filePath = public_path('soal_images');
                $fileName = uniqid() . '.png';
                $fullPath = $filePath . '/' . $fileName;

                if (!file_exists($filePath)) {
                    mkdir($filePath, 0755, true);
                }

                file_put_contents($fullPath, $imageData);
                $pertanyaan = 'soal_images/' . $fileName;
            } else {
                return response()->json(['error' => 'Failed to decode base64 image'], 400);
            }
        }

        // Handle file uploads for multiple-choice options
        foreach ($request->gambar_pilihan as $key => $gambar_pilihan) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $gambar_pilihan['imgData']));
            if ($imageData !== false) {
                $filePath = public_path('ujian_pg');
                $fileName = uniqid() . '.png';
                $fullPath = $filePath . '/' . $fileName;

                if (!file_exists($filePath)) {
                    mkdir($filePath, 0755, true);
                }

                file_put_contents($fullPath, $imageData);

                if ($gambar_pilihan['namegambar'] == 'A') $pathsA = 'A. ' . 'ujian_pg/' . $fileName;
                if ($gambar_pilihan['namegambar'] == 'B') $pathsB = 'B. ' . 'ujian_pg/' . $fileName;
                if ($gambar_pilihan['namegambar'] == 'C') $pathsC = 'C. ' . 'ujian_pg/' . $fileName;
                if ($gambar_pilihan['namegambar'] == 'D') $pathsD = 'D. ' . 'ujian_pg/' . $fileName;
                if ($gambar_pilihan['namegambar'] == 'E') $pathsE = 'E. ' . 'ujian_pg/' . $fileName;
                if ($gambar_pilihan['namegambar'] == 'F') $pathsF = 'F. ' . 'ujian_pg/' . $fileName;
            }
        }

        $detail_ujian_data = [
            'soal' => $pertanyaan,
            'pg_1' => $pathsA,
            'pg_2' => $pathsB,
            'pg_3' => $pathsC,
            'pg_4' => $pathsD,
            'pg_5' => $pathsE,
            'pg_6' => $pathsF,
            'jawaban' => $request->jawaban_benar,
        ];

        if ($DetailUjian) {
            $DetailUjian->update($detail_ujian_data);
        } else {
            $detail_ujian_data['kode'] =  $uj->kode;

            DetailUjian::create($detail_ujian_data);
        }

        return response()->json([
            'message' => 'Soal berhasil diupload',
            'data' => $uj,
            'detail_ujian' => $detail_ujian_data,
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ujian  $ujian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ujian $ujian)
    {

        WaktuUjian::where('kode', $ujian->kode)
            ->delete();

        if ($ujian->jenis == 0) {
            DetailUjian::where('kode', $ujian->kode)
                ->delete();

            PgSiswa::where('kode', $ujian->kode)
                ->delete();
        } else {
            DetailEssay::where('kode', $ujian->kode)
                ->delete();

            EssaySiswa::where('kode', $ujian->kode)
                ->delete();
        }

        Ujian::destroy($ujian->id);

        return redirect('/guru/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }


    public function ujian_cetak($kode)
    {
        return view('guru.ujian.cetak-pg', [
            'ujian' => Ujian::firstWhere('kode', $kode)
        ]);
    }
    public function ujian_ekspor($kode)
    {
        $ujian =  Ujian::firstWhere('kode', $kode);
        $nama_kelas = $ujian->kelas->nama_kelas;
        return Excel::download(new PgExport($ujian), "nilai-pg-kelas-$nama_kelas.xlsx");
    }

    function create_ujian_simulator($id)
    {
        $ujian = Ujian::whereId($id)->first();
        // dd($ujian->simulasiPg);
        return view('guru.ujian.create-simulator-pg', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' =>  $ujian->kode,
            'detailPg' => $ujian->detailPg,
            'ujianData' => $ujian,
            'simulasiPg' => $ujian->simulasiPg,
        ]);
    }

    function store_ujian_simulator_copy(Request $request, $id)
    {

        try {
            // Ambil semua data dari tabel detail_ujian
            $detailUjianData = DetailUjian::whereId($request->soal_choice)->first();
            $ujian = Ujian::whereId($id)->first();
            $simulasi = SimulatorUjianPg::where('kode', $ujian->kode)->first();
            $data = [
                'kode'   => $ujian->kode,
                'soal'   => $detailUjianData->soal,
                'pg_1'   => $detailUjianData->pg_1,
                'pg_2'   => $detailUjianData->pg_2,
                'pg_3'   => $detailUjianData->pg_3,
                'pg_4'   => $detailUjianData->pg_4,
                'pg_5'   => $detailUjianData->pg_5,
                'pg_6'   => $detailUjianData->pg_6,
                'jawaban' => $detailUjianData->jawaban,
            ];
            if ($simulasi) {
                $simulasi->update($data);
            } else {
                SimulatorUjianPg::create($data);
            }

            // Siapkan array untuk data yang akan diinsert ke simulai_ujan
            return back()->with('success', 'Simulasi Ujian berhasil dibuat.');
        } catch (\Throwable $e) {
            Log::error('Error duplicating data: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat Simulasi Ujian. Periksa log untuk detail lebih lanjut.');
        }
    }

    public function essay_cetak($kode)
    {
        return view('guru.ujian.cetak-essay', [
            'ujian' => Ujian::firstWhere('kode', $kode)
        ]);
    }
    public function essay_ekspor($kode)
    {
        $ujian =  Ujian::firstWhere('kode', $kode);
        $nama_kelas = $ujian->kelas->nama_kelas;
        return Excel::download(new EssayExport($ujian), "nilai-essay-kelas-$nama_kelas.xlsx");
    }

    public function ujian_reset($kode, $siswa_id)
    {
        $ujian = Ujian::firstWhere('kode', $kode);
        if ($ujian->jenis == 0) {
            // ujian pg
            $waktu_ujian = [
                'waktu_berakhir' => null,
                'selesai' => null
            ];
            WaktuUjian::where('kode', $kode)
                ->where('siswa_id', $siswa_id)
                ->update($waktu_ujian);
            PgSiswa::where('kode', $kode)
                ->where('siswa_id', $siswa_id)
                ->delete();

            return redirect('/guru/ujian' . '/' . $kode)->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'ujian siswa di reset!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }
        if ($ujian->jenis == 1) {
            // ujian essay
            $waktu_ujian = [
                'waktu_berakhir' => null,
                'selesai' => null
            ];
            WaktuUjian::where('kode', $kode)
                ->where('siswa_id', $siswa_id)
                ->update($waktu_ujian);
            EssaySiswa::where('kode', $kode)
                ->where('siswa_id', $siswa_id)
                ->delete();

            return redirect('/guru/ujian_essay' . '/' . $kode)->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'ujian siswa di reset!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }
    public function ujian_reset_all($kode)
    {
        $ujian = Ujian::firstWhere('kode', $kode);
        if ($ujian->jenis == 0) {
            // ujian pg
            $waktu_ujian = [
                'waktu_berakhir' => null,
                'selesai' => null
            ];
            WaktuUjian::where('kode', $kode)
                ->update($waktu_ujian);
            PgSiswa::where('kode', $kode)
                ->delete();

            return redirect('/guru/ujian' . '/' . $kode)->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'ujian semua siswa di reset!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }
        if ($ujian->jenis == 1) {
            // ujian essay
            $waktu_ujian = [
                'waktu_berakhir' => null,
                'selesai' => null
            ];
            WaktuUjian::where('kode', $kode)
                ->update($waktu_ujian);
            EssaySiswa::where('kode', $kode)
                ->delete();

            return redirect('/guru/ujian_essay' . '/' . $kode)->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'ujian semua siswa di reset!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }


    function hasil_ujian_siswa($kode, $id)
    {
        $siswa = Siswa::whereId($id)->first();
        // dd($siswa);
        $merg = MergeUjian::join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', '=', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', 'rum.kode_ujian')
            ->select('ujian.*')
            ->get();
        $hasilPg = []; // Inisialisasi array
        $hasilKuisoner = []; // Inisialisasi array
        $hasilEsay = []; // Inisialisasi array
        $hasilVisual = []; // Inisialisasi array
        $totalEssayScore = 0; // Initialize total essay score

        foreach ($merg as $key => $value) {
            if ($value->jenis == 0) {
                // Panggil fungsi dan simpan hasilnya
                $pilihanGanda = UjianServiceController::pilihan_ganda_siswa($value->kode, $siswa->id);
                // Pastikan hasilnya adalah array, dan cek apakah indeks [0][0] ada
                $hasilPg[] = isset($pilihanGanda[0]) ? $pilihanGanda[0] : null;
            }
            if ($value->jenis == 1) {

                // Panggil fungsi dan simpan hasilnya
                $pilihanEsay = UjianServiceController::pilihan_esay_siswa($value->kode, $siswa->id);
                // Pastikan hasilnya adalah array, dan cek apakah indeks [0][0] ada
                $hasilEsay[] = isset($pilihanEsay[0]) ? $pilihanEsay[0] : null;
                // Calculate total essay score
                if (isset($pilihanEsay[0])) {
                    $totalEssayScore += $pilihanEsay[0]['total_nilai'];
                }
            }
            if ($value->jenis == 2) {
                // Panggil fungsi dan simpan hasilnya
                $pilihanKuisoner = UjianServiceController::pilihan_kusoner_siswa($value->kode, $siswa->id);
                // Pastikan hasilnya adalah array, dan cek apakah indeks [0][0] ada
                $hasilKuisoner[] = isset($pilihanKuisoner[0]) ? $pilihanKuisoner[0] : null;
            }
            if ($value->jenis == 3) {
                // Panggil fungsi dan simpan hasilnya
                $pilihanVisual = UjianServiceController::pilihan_visual_siswa($value->kode, $siswa->id);
                // Pastikan hasilnya adalah array, dan cek apakah indeks [0][0] ada
                $hasilVisual[] = isset($pilihanVisual[0]) ? $pilihanVisual[0] : null;
            }
        }

        //    $hasilPg = []; // Inisialisasi array
        //    $hasilKuisoner = []; // Inisialisasi array
        //    $hasilhasilEsay= []; // Inisialisasi array
        //    $hasilVisual= []; // Inisialisasi array

        //  dd($hasilEsay);
        return view('guru.ujian.hasil_ujian', [
            'title' => 'Tambah Ujian Essay',
            'plugin' => '
                    <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                    <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'siswa' => $siswa,
            'hasilPg' => $hasilPg,
            'hasilKuisoner' => $hasilKuisoner,
            'hasilEsay' => $hasilEsay,
            'hasilVisual' => $hasilVisual,
            'totalEssayScore' => $totalEssayScore, // Pass total essay score to the view
        ]);
    }


    function create_ujian_intruksi($id)
    {
        $ujian = Ujian::whereId($id)->first();
        $intruksi = IntruksiUjian::where('kode', $ujian->kode)->get();
        // dd($intruksi->kode);
        return view('guru.ujian.create-intruksi-pg', [
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
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'guru_mapel' => Gurumapel::where('guru_id', session()->get('id'))->get(),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get(),
            'kode' =>  $ujian->kode,
            'detailPg' => $ujian->detailPg,
            'ujianData' => $ujian,
            'intruksi' => $intruksi,
            'simulasiPg' => $ujian->simulasiPg,
        ]);
    }

    function store_ujian_intruksi(Request $request)
    {
        // dd($request);
        // $validated = $request->validate([
        //     'label' => 'required|string|max:255',
        //     'intruksi' => 'required|string',
        // ]);

        foreach ($request->label as $key => $value) {
            $varData = [
                'label' => $value,
                'kode' => $request->kode,
                'intruksi' => $request->intruksi[$key],
            ];
            $data = IntruksiUjian::whereId($request->id[$key])->first();
            if ($data) {
                $data->update($varData);
            } else {
                IntruksiUjian::create($varData);
            }
        }
        // dd($request);

        return back()->with('success', 'Instruksi berhasil Modif    .');
    }
}
