<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Gurukelas;
use App\Models\MergeUjian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan_ujian_siswa(Request $request)
    {
        $search = $request->input('search');

        $MergeUjianSiswa = MergeUjian::join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', '=', 'merge_ujian.kode')
            ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
            ->join('detail_ujian', 'detail_ujian.kode', '=', 'ujian.kode')
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
            ->where(function ($query) {
                $query->whereNotNull('siswa_pg.nama_siswa')
                    ->orWhereNotNull('siswa_visual.nama_siswa')
                    ->orWhereNotNull('siswa_essay.nama_siswa')
                    ->orWhereNotNull('siswa_kuesioner.nama_siswa');
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('siswa_pg.nama_siswa', 'like', "%{$search}%")
                        ->orWhere('siswa_visual.nama_siswa', 'like', "%{$search}%")
                        ->orWhere('siswa_essay.nama_siswa', 'like', "%{$search}%")
                        ->orWhere('siswa_kuesioner.nama_siswa', 'like', "%{$search}%");
                });
            })
            ->distinct()
            ->get();
        return view('guru.laporan.laporan_ujian_siswa', [
            'title' => 'Data Tes',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'laporan_ujian_siswa',
                'expanded' => 'laporan_ujian_siswa'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'guru_kelas' => Gurukelas::where('guru_id', session()->get('id'))->get(),
            'merge_ujian' => MergeUjian::join('kelas', 'kelas.id', '=', 'merge_ujian.kelas_id')->get(),
            'MergeUjianSiswa' => $MergeUjianSiswa
        ]);
    }
}
