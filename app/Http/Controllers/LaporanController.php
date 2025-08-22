<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Gurukelas;
use App\Models\Kelas;
use App\Models\MergeUjian;
use App\Models\Siswa;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan_ujian_siswa(Request $request)
    {
        $search = $request->input('search');
        $kelas_id = $request->input('batch');
        $perPage = $request->input('limit', 10);
        $page = $request->input('page', 1);


        $MergeUjianSiswa = Siswa::when($search, function ($query, $search) {
            return $query->where('nama_siswa', 'like', "%{$search}%");
        })
            ->when($kelas_id, function ($query, $kelas_id) {
                return $query->where('kelas_id', $kelas_id);
            })
            ->orderBy('id', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        $batch = Kelas::all();
        // dd($batch);

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
            'batch' => $batch,
            'MergeUjianSiswa' => $MergeUjianSiswa,
            'currentPage' => ($MergeUjianSiswa->currentPage() - 1) * 10,
        ]);
    }
}
