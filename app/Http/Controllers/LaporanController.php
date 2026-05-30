<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan_ujian_siswa(Request $request)
    {
        return view('guru.laporan.laporan_ujian_siswa', [
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'title' => 'Data Tes',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
            ',
            'menu' => [
                'menu'     => 'laporan_ujian_siswa',
                'expanded' => 'laporan_ujian_siswa',
            ],
        ]);
    }
}
