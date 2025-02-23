<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\MergeUjian;
use App\Models\Notifikasi;
use App\Models\TugasSiswa;
use App\Models\WaktuUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        $notif_merge_ujian = MergeUjian::join('relasi_ujian_merge as rum','rum.kode_merge_ujian','=','merge_ujian.kode')
        ->join('ujian','ujian.kode','=','rum.kode_ujian')
        ->join('kelas','kelas.id','=','merge_ujian.kelas_id')
        ->join('siswa','siswa.kelas_id','=','kelas.id')
        ->where('siswa.id', session()->get('id'))
        // ->where('selesai', null)
        ->select('merge_ujian.*')
        ->distinct()
        ->get();
        
        $siswa = Siswa::firstWhere('id', session()->get('id'));
        $cekMergeUjian = MergeUjian::
        join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode') 
        ->where('merge_ujian.kelas_id', $siswa->kelas_id)->get();
 
        foreach ($cekMergeUjian as $key => $value) {
            $waktu_ujian = WaktuUjian::where('kode', $value->kode_ujian)
                ->where('siswa_id', session()->get('id'))
                ->first();
                if(!$waktu_ujian){
                   WaktuUjian::create([
                        'kode' => $value->kode_ujian,
                        'siswa_id' => session()->get('id'),
                        // 'waktu_berakhir' => date('Y-m-d H:i:s', strtotime('+' . $value->jam . ' hours +' . $value->menit . ' minutes')),
                        'selesai' => 0
                    ]); 
                }
        }
        // dd($siswa);
        $mergeUjian = MergeUjian::join('relasi_ujian_merge as rum', 'rum.kode_merge_ujian', 'merge_ujian.kode')
        ->join('ujian', 'ujian.kode', '=', 'rum.kode_ujian')
        ->leftJoin('waktu_ujian', function ($join) {
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

       
        //  dd($notif_merge_ujian);
        //  dd($mergeUjian);
        return view('siswa.dashboard', [
            'title' => 'Dashboard Siswa',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/assets/js/dashboard/dash_1.js"></script>
            ',
            'menu' => [
                'menu' => 'dashboard',
                'expanded' => 'dashboard'
            ],
            'siswa' => $siswa,
            'materi' => Materi::where('kelas_id', $siswa->kelas_id)->get(),
            'tugas' => TugasSiswa::where('siswa_id', session()->get('id'))->get(),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian,
            'notif_merge_ujian' => $notif_merge_ujian,
            'mergeUjian' => $mergeUjian,
        ]);
    }
    public function profile()
    {
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        return view('siswa.profile', [
            'title' => 'My Profile',
            'plugin' => '
                <link href="' . url("assets/cbt-malela") . '/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
            ',
            'menu' => [
                'menu' => 'profile',
                'expanded' => 'profile'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian
        ]);
    }
    public function edit_profile(Siswa $siswa, Request $request)
    {
        $rules = [
            'nama_siswa' => 'required|max:255',
            'avatar' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('avatar')) {
            if ($request->gambar_lama) {
                if ($request->gambar_lama != 'default.png') {
                    Storage::delete('assetsuser-profile/' . $request->gambar_lama);
                }
            }
            $validatedData['avatar'] = str_replace('assets/user-profile/', '', $request->file('avatar')->store('assets/user-profile'));
        }
        Siswa::where('id', $siswa->id)
            ->update($validatedData);

        return redirect('/siswa/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'profile updated!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function edit_password(Request $request, Siswa $siswa)
    {
        if (Hash::check($request->current_password, $siswa->password)) {
            $data = [
                'password' => bcrypt($request->password)
            ];
            siswa::where('id', $siswa->id)
                ->update($data);

            return redirect('/siswa/profile')->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'password updated!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return redirect('/siswa/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Error!',
                    text: 'current password salah!',
                    type: 'error',
                    padding: '2em'
                })
            </script>
        ");
    }
}
