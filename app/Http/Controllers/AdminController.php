<?php

namespace App\Http\Controllers;

use App\Models\EmailSettings;
use App\Models\Guru;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Gurukelas;
use App\Models\Gurumapel;
use App\Exports\GuruExport;
use App\Imports\GuruImport;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Jobs\QueueEmailNotifAkun;
use App\Mail\NotifAkun;
use App\Models\DetailEssay;
use App\Models\DetailUjian;
use App\Models\EssaySiswa;
use App\Models\FileModel;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\PgSiswa;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\Ujian;
use App\Models\Userchat;
use App\Models\WaktuUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/assets/js/dashboard/dash_1.js"></script>
            ',
            'menu' => [
                'menu' => 'dashboard',
                'expanded' => 'dashboard',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'guru' => Guru::all(),
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all(),
            'mapel' => Mapel::all(),
        ]);
    }
    public function profile()
    {
        return view('admin.profile-settings', [
            'title' => 'Profile and Settings',
            'plugin' => '
                <link href="' . url("assets/cbt-malela") . '/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
                <link rel="stylesheet" type="text/css" href="' . url("assets/cbt-malela") . '/assets/css/forms/theme-checkbox-radio.css">
            ',
            'menu' => [
                'menu' => 'profile',
                'expanded' => 'profile',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'email_settings' => EmailSettings::first()
        ]);
    }

    public function edit_profile(Request $request, Admin $admin)
    {
        $rules = [
            'nama_admin' => 'required|max:255',
            'avatar' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('avatar')) {
            $avatarFile = $request->file('avatar');
            $fileName = time() . '_' . $avatarFile->getClientOriginalName();

            // Path tujuan: public/assets/user-profile
            $destinationPath = public_path('assets/user-profile');

            // Hapus gambar lama jika bukan default
            if ($request->gambar_lama && $request->gambar_lama !== 'default.png') {
                $oldImagePath = $destinationPath . '/' . $request->gambar_lama;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Pindahkan file baru ke folder public/assets/user-profile
            $avatarFile->move($destinationPath, $fileName);

            $validatedData['avatar'] = $fileName;
        }

        Admin::where('id', $admin->id)->update($validatedData);

        return redirect('/admin/profile')->with('pesan', "
        <script>
            swal({
                title: 'Success!',
                text: 'Profile updated!',
                type: 'success',
                padding: '2em'
            })
        </script>
    ");
    }

    public function edit_password(Request $request, Admin $admin)
    {
        if (Hash::check($request->current_password, $admin->password)) {
            $data = [
                'password' => bcrypt($request->password)
            ];
            Admin::where('id', $admin->id)
                ->update($data);

            return redirect('/admin/profile')->with('pesan', "
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

        return redirect('/admin/profile')->with('pesan', "
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
    public function smtp_email(Request $request, $id)
    {
        $data = [
            'notif_akun' => $request->notif_akun,
            'notif_materi' => $request->notif_materi,
            'notif_tugas' => $request->notif_tugas,
            'notif_ujian' => $request->notif_ujian,
        ];

        EmailSettings::where('id', $id)
            ->update($data);

        return redirect('/admin/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'pengaturan email di ubah!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    // START==SIWA
    public function siswa()
    {
        return view('admin.siswa.index', [
            'title' => 'Data Siswa',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'master',
                'expanded' => 'master',
                'collapse' => 'master',
                'sub' => 'siswa',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all()
        ]);
    }
    public function tambah_siswa_(Request $request)
    {
        $email_settings = EmailSettings::first();
        $niss = $request->get('nis');

        $siswa = [];
        $nis_sebelumnya = '';
        $email_sebelumnya = '';
        $index = 0;
        foreach ($niss as $nis) {

            if ($nis == $nis_sebelumnya) {
                return redirect('/admin/siswa')->with('pesan', "
                    <script>
                        swal({
                            title: 'Error!',
                            text: 'Duplicate data NIS detected!',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
            if ($request['email'][$index] == $email_sebelumnya) {
                return redirect('/admin/siswa')->with('pesan', "
                    <script>
                        swal({
                            title: 'Error!',
                            text: 'Duplicate data Email detected!',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }

            array_push($siswa, [

                'nis' => $nis,
                'nama_siswa' => $request['nama_siswa'][$index],
                'gender' => $request['gender'][$index],
                'kelas_id' => $request['kelas_id'][$index],
                'email' => $request['email'][$index],
                'password' => bcrypt($nis),
                'avatar' => 'default.png',
                'role' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s', time())
            ]);
            $nis_sebelumnya = $nis;
            $email_sebelumnya = $request['email'][$index];
            $index++;
        }

        try {
            Siswa::insert($siswa);

            if ($email_settings->notif_akun == '1') {
                foreach ($siswa as $s) {
                    $details = [
                        'nama' => $s['nama_siswa'],
                        'email' => $s['email'],
                        'password' => $s['nis']
                    ];
                    Mail::to($details['email'])->send(new NotifAkun($details));
                }
            }

            return redirect('/admin/siswa')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'data siswa di simpan!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Exception $exceptions) {
            $pesan_error = str_replace('\'', '\`', $exceptions->errorInfo[2]);
            return redirect('/admin/siswa')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: '$pesan_error',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }
    public function edit_siswa(Request $request)
    {
        $nis = $request->nis;
        $siswa = Siswa::firstWhere('nis', $nis);
        echo json_encode($siswa);
    }
    public function edit_siswa_(Request $request)
    {
        $siswa = Siswa::firstWhere('id', $request->input('id'));
        $rules = [
            'nama_siswa' => 'required',
            'gender' => 'required',
            'kelas_id' => 'required',
            'is_active' => 'required'
        ];
        if ($request->input('email') != $siswa->email) {
            $rules['email'] = 'required|email:dns|unique:siswa';
        }

        $validate = $request->validate($rules);

        Siswa::where('id', $request->input('id'))
            ->update($validate);

        return redirect('/admin/siswa')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data siswa di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function impor_siswa()
    {
        return response()->download('assets/file-excel/siswa.xlsx');
    }
    public function impor_siswa_(Request $request)
    {
        $email_settings = EmailSettings::first();

        $siswa_excel = Excel::toArray(new SiswaImport, $request->file);
        if (count($siswa_excel) < 0) {
            return redirect('/admin/siswa')->with('pesan', "
                <script>
                    swal({
                        title: 'Info!',
                        text: 'tidak ada data di dalam file yang di upload',
                        type: 'info',
                        padding: '2em'
                    })
                </script>
            ");
        }

        try {
            Excel::import(new SiswaImport, $request->file);

            if ($email_settings->notif_akun == '1') {
                foreach ($siswa_excel[0] as $s) {
                    $details = [
                        'nama' => $s['nama_siswa'],
                        'email' => $s['email'],
                        'password' => $s['nis']
                    ];
                    Mail::to($details['email'])->send(new NotifAkun($details));
                }
            }

            return redirect('/admin/siswa')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'import data siswa berhasil!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Exception $exceptions) {
            if ($exceptions->getCode() != 0) {
                $pesan_error = str_replace('\'', '\`', $exceptions->errorInfo[2]);
            } else {
                $pesan_error = $exceptions->getMessage();
            }

            return redirect('/admin/siswa')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: '$pesan_error',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }
    public function hapus_siswa(Siswa $siswa)
    {
        WaktuUjian::where('siswa_id', $siswa->id)
            ->delete();
        Userchat::where('email', $siswa->email)
            ->delete();
        TugasSiswa::where('siswa_id', $siswa->id)
            ->delete();
        PgSiswa::where('siswa_id', $siswa->id)
            ->delete();
        EssaySiswa::where('siswa_id', $siswa->id)
            ->delete();
        Notifikasi::where('siswa_id', $siswa->id)
            ->delete();

        Siswa::destroy($siswa->id);
        return redirect('/admin/siswa')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data siswa berhasil di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function ekspor_siswa()
    {
        return Excel::download(new SiswaExport, 'data-siswa.xlsx');
    }

    public function guru()
    {
        return view('admin.guru.index', [
            'title' => 'Data Guru',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'master',
                'expanded' => 'master',
                'collapse' => 'master',
                'sub' => 'guru',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'guru' => Guru::all()
        ]);
    }
    public function tambah_guru_(Request $request)
    {
        $email_settings = EmailSettings::first();

        $emails = $request->get('email');

        $guru = [];
        $email_sebelumnya = '';
        $index = 0;
        foreach ($emails as $email) {

            if ($email == $email_sebelumnya) {
                return redirect('/admin/guru')->with('pesan', "
                    <script>
                        swal({
                            title: 'Error!',
                            text: 'Duplicate data email detected!',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
            array_push($guru, [
                'nama_guru' => $request['nama_guru'][$index],
                'gender' => $request['gender'][$index],
                'email' => $email,
                'password' => bcrypt('123'),
                'avatar' => 'default.png',
                'role' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);

            $email_sebelumnya = $email;
            $index++;
        }

        try {
            Guru::insert($guru);

            if ($email_settings->notif_akun == '1') {
                foreach ($guru as $s) {
                    // Kirim Email ke Guru
                    $details = [
                        'nama' => $s['nama_guru'],
                        'email' => $s['email'],
                        'password' => '123'
                    ];
                    Mail::to($details['email'])->send(new NotifAkun($details));
                }
            }

            return redirect('/admin/guru')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'data guru di simpan!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Exception $exceptions) {
            $pesan_error = str_replace('\'', '\`', $exceptions->errorInfo[2]);
            return redirect('/admin/guru')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: '$pesan_error',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }
    public function edit_guru(Request $request)
    {
        $id_guru = $request->id_guru;
        $guru = guru::firstWhere('id', $id_guru);
        echo json_encode($guru);
    }
    public function edit_guru_(Request $request)
    {
        $guru = Guru::firstWhere('id', $request->input('id'));
        $rules = [
            'nama_guru' => 'required',
            'gender' => 'required',
            'is_active' => 'required'
        ];
        if ($request->input('email') != $guru->email) {
            $rules['email'] = 'required|email:dns|unique:guru';
        }

        $validate = $request->validate($rules);

        Guru::where('id', $request->input('id'))
            ->update($validate);

        return redirect('/admin/guru')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data guru di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function impor_guru()
    {
        return response()->download('assets/file-excel/guru.xlsx');
    }
    public function impor_guru_(Request $request)
    {
        $email_settings = EmailSettings::first();

        $guru_excel = Excel::toArray(new GuruImport, $request->file);
        if (count($guru_excel) < 0) {
            return redirect('/admin/guru')->with('pesan', "
                <script>
                    swal({
                        title: 'Info!',
                        text: 'tidak ada data di dalam file yang di upload',
                        type: 'info',
                        padding: '2em'
                    })
                </script>
            ");
        }

        try {
            Excel::import(new GuruImport, $request->file);

            if ($email_settings->notif_akun == '1') {
                foreach ($guru_excel[0] as $s) {
                    // Kirim Email ke Guru
                    $details = [
                        'nama' => $s['nama_guru'],
                        'email' => $s['email'],
                        'password' => '123'
                    ];
                    Mail::to($details['email'])->send(new NotifAkun($details));
                }
            }

            return redirect('/admin/guru')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'import data guru berhasil!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Exception $exceptions) {
            if ($exceptions->getCode() != 0) {
                $pesan_error = str_replace('\'', '\`', $exceptions->errorInfo[2]);
            } else {
                $pesan_error = $exceptions->getMessage();
            }

            return redirect('/admin/guru')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: '$pesan_error',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }
    public function hapus_guru(Guru $guru)
    {
        Gurukelas::where('guru_id', $guru->id)
            ->delete();
        Gurumapel::where('guru_id', $guru->id)
            ->delete();

        $materi = Materi::where('guru_id', $guru->id)->get();
        foreach ($materi as $m) {
            Notifikasi::where('kode', $m->kode)
                ->delete();
            Userchat::where('key', $m->kode)
                ->delete();
            FileModel::where('kode', $m->kode)
                ->delete();
        }
        Materi::where('guru_id', $guru->id)
            ->delete();

        $tugas = Tugas::where('guru_id', $guru->id)->get();
        foreach ($tugas as $t) {
            TugasSiswa::where('kode', $t->kode)
                ->delete();
            Userchat::where('key', $t->kode)
                ->delete();
            FileModel::where('kode', $t->kode)
                ->delete();
        }
        Tugas::where('guru_id', $guru->id)
            ->delete();

        $ujian = Ujian::where('guru_id', $guru->id)->get();
        foreach ($ujian as $u) {
            DetailUjian::where('kode', $u->kode)
                ->delete();
            PgSiswa::where('kode', $u->kode)
                ->delete();
            DetailEssay::where('kode', $u->kode)
                ->delete();
            EssaySiswa::where('kode', $u->kode)
                ->delete();
            WaktuUjian::where('kode', $u->kode)
                ->delete();
        }
        Ujian::where('guru_id', $guru->id)
            ->delete();

        Guru::destroy($guru->id);
        return redirect('/admin/guru')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data guru berhasil di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function ekspor_guru()
    {
        return Excel::download(new GuruExport, 'data-guru.xlsx');
    }

    public function kelas()
    {
        return view('admin.kelas.index', [
            'title' => 'Data batch',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'batch',
                'expanded' => 'batch',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'kelas' => Kelas::all()
        ]);
    }
    public function tambah_kelas(Request $request)
    {
        $kelass = $request->get('nama_kelas');

        $data_kelas = [];
        $index = 0;
        foreach ($kelass as $kelas) {

            array_push($data_kelas, [

                'nama_kelas' => $kelas,

            ]);

            $index++;
        }

        Kelas::insert($data_kelas);

        return redirect('/admin/kelas')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data kelas di simpan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function edit_kelas(Request $request)
    {
        $validate = $request->validate([
            'nama_kelas' => 'required'
        ]);

        Kelas::where('id', $request->input('id'))
            ->update($validate);

        return redirect('/admin/kelas')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data batch di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function hapus_kelas(Kelas $kelas)
    {
        Siswa::where('kelas_id', $kelas->id)
            ->delete();

        $materi = Materi::where('kelas_id', $kelas->id)->get();
        foreach ($materi as $m) {
            Notifikasi::where('kode', $m->kode)
                ->delete();
            Userchat::where('key', $m->kode)
                ->delete();
            FileModel::where('kode', $m->kode)
                ->delete();
        }
        Materi::where('kelas_id', $kelas->id)
            ->delete();

        $tugas = Tugas::where('kelas_id', $kelas->id)->get();
        foreach ($tugas as $t) {
            TugasSiswa::where('kode', $t->kode)
                ->delete();
            Userchat::where('key', $t->kode)
                ->delete();
            FileModel::where('kode', $t->kode)
                ->delete();
        }
        Tugas::where('kelas_id', $kelas->id)
            ->delete();

        $ujian = Ujian::where('kelas_id', $kelas->id)->get();
        foreach ($ujian as $u) {
            DetailUjian::where('kode', $u->kode)
                ->delete();
            PgSiswa::where('kode', $u->kode)
                ->delete();
            DetailEssay::where('kode', $u->kode)
                ->delete();
            EssaySiswa::where('kode', $u->kode)
                ->delete();
            WaktuUjian::where('kode', $u->kode)
                ->delete();
        }
        Ujian::where('kelas_id', $kelas->id)
            ->delete();

        Gurukelas::where('kelas_id', $kelas->id)
            ->delete();

        Kelas::destroy($kelas->id);
        return redirect('/admin/kelas')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data kelas berhasil di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    // END==KELAS

    // START==MAPEL
    public function mapel()
    {
        return view('admin.mapel.index', [
            'title' => 'Data Mapel',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'mapel',
                'expanded' => 'mapel',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'mapel' => Mapel::all()
        ]);
    }
    public function tambah_mapel(Request $request)
    {
        $mapels = $request->get('nama_mapel');

        $data_mapel = [];
        $index = 0;
        foreach ($mapels as $mapel) {

            array_push($data_mapel, [

                'nama_mapel' => $mapel,

            ]);

            $index++;
        }

        Mapel::insert($data_mapel);

        return redirect('/admin/mapel')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data mapel di simpan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function edit_mapel(Request $request)
    {
        $validate = $request->validate([
            'nama_mapel' => 'required'
        ]);

        Mapel::where('id', $request->input('id'))
            ->update($validate);

        return redirect('/admin/mapel')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data mapel di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function hapus_mapel(Mapel $mapel)
    {
        $materi = Materi::where('mapel_id', $mapel->id)->get();
        foreach ($materi as $m) {
            Notifikasi::where('kode', $m->kode)
                ->delete();
            Userchat::where('key', $m->kode)
                ->delete();
            FileModel::where('kode', $m->kode)
                ->delete();
        }
        Materi::where('mapel_id', $mapel->id)
            ->delete();

        $tugas = Tugas::where('mapel_id', $mapel->id)->get();
        foreach ($tugas as $t) {
            TugasSiswa::where('kode', $t->kode)
                ->delete();
            Userchat::where('key', $t->kode)
                ->delete();
            FileModel::where('kode', $t->kode)
                ->delete();
        }
        Tugas::where('mapel_id', $mapel->id)
            ->delete();

        $ujian = Ujian::where('mapel_id', $mapel->id)->get();
        foreach ($ujian as $u) {
            DetailUjian::where('kode', $u->kode)
                ->delete();
            PgSiswa::where('kode', $u->kode)
                ->delete();
            DetailEssay::where('kode', $u->kode)
                ->delete();
            EssaySiswa::where('kode', $u->kode)
                ->delete();
            WaktuUjian::where('kode', $u->kode)
                ->delete();
        }
        Ujian::where('mapel_id', $mapel->id)
            ->delete();

        Gurumapel::where('mapel_id', $mapel->id)
            ->delete();

        Mapel::destroy($mapel->id);
        return redirect('/admin/mapel')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data mapel berhasil di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    // END==MAPEL

    public function relasi()
    {
        return view('admin.guru.relasi-index', [
            'title' => 'Data Relasi',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'relasi',
                'expanded' => 'relasi',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'guru' => Guru::all()
        ]);
    }
    public function relasi_guru(Guru $guru)
    {
        // dd($guru);
        return view('admin.guru.relasi-guru', [
            'title' => 'Data Relasi',
            'plugin' => '

            ',
            'menu' => [
                'menu' => 'relasi',
                'expanded' => 'relasi',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'guru' => $guru,
            'mapel' => Mapel::all(),
            'kelas' => Kelas::all(),
        ]);
    }
    public function guru_kelas(Request $request)
    {
        $id_guru = $request->id_guru;
        $id_kelas = $request->id_kelas;

        $where = [
            'guru_id' => $id_guru,
            'kelas_id' => $id_kelas,
        ];

        $result = Gurukelas::where($where)->get();

        if (count($result) > 0) {
            Gurukelas::where($where)
                ->delete();
        } else {
            Gurukelas::insert($where);
        }
    }
    public function guru_mapel(Request $request)
    {
        $id_guru = $request->id_guru;
        $id_mapel = $request->id_mapel;

        $where = [
            'guru_id' => $id_guru,
            'mapel_id' => $id_mapel,
        ];

        $result = Gurumapel::where($where)->get();

        if (count($result) > 0) {
            Gurumapel::where($where)
                ->delete();
        } else {
            Gurumapel::insert($where);
        }
    }
}
