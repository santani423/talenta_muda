<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\Guru;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Token;
use Illuminate\Support\Str;
use App\Mail\VerifikasiAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class AuthController extends Controller
{
    public function __construct() {}

    public function index()
    {
        if (session('admin') != null) {
            return redirect('/admin');
        }

        return view('auth.login', [
            "title" => "Login Form",
            "admin" => Admin::all()
        ]);
    }
    public function login(Request $request)
    {
        $admin = Admin::firstWhere('email', $request->input('email'));
        if ($admin) {
            if (Hash::check($request->input('password'), $admin->password)) {
                $request->session()->put('id', $admin->id);
                $request->session()->put('email', $admin->email);
                $request->session()->put('role', 1);
                return redirect()->intended('/admin')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/login')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        $guru = Guru::firstWhere('email', $request->input('email'));
        if ($guru) {

            if ($guru->is_active == 0) {
                return redirect('/login')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'akun tidak aktif',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }

            if (Hash::check($request->input('password'), $guru->password)) {
                $request->session()->put('id', $guru->id);
                $request->session()->put('email', $guru->email);
                $request->session()->put('nama_guru', $guru->nama_guru);
                $request->session()->put('role', 2);
                return redirect()->intended('/guru')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/login')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        $siswa = Siswa::firstWhere('email', $request->input('email'));
        if ($siswa) {

            if ($siswa->is_active == 0) {
                return redirect('/login')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'akun tidak aktif',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }

            if (Hash::check($request->input('password'), $siswa->password)) {
                $request->session()->put('id', $siswa->id);
                $request->session()->put('email', $siswa->email);
                $request->session()->put('role', 3);
                return redirect()->intended('/siswa')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/login')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        return redirect('/login')->with('pesan', "
            <script>
                swal({
                    title: 'Login Failed!',
                    text: 'Akun tidak ditemukan',
                    type: 'error',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function install()
    {
        $admin = Admin::all();
        if ($admin->count() != 0) {
            return redirect('/login')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'Akun admin sudah dibuat',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return view('auth.install', [
            "title" => "Installasi Admin"
        ]);
    }
    public function install_(Request $request)
    {
        $validate = $request->validate([
            'nama_admin' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $validate['password'] = Hash::make($validate['password']);
        Admin::create($validate);
        return redirect('/login')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'Akun admin berhasil dibuat',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function register()
    {
        $admin = Admin::all();
        if ($admin->count() == 0) {
            return redirect()->action([AuthController::class, 'index']);
        }

        return view('auth.register', [
            "title" => "Daftar Akun ",
            "kelas" => Kelas::all()
        ]);
    }
    public function register_(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'gender' => 'required',
            'kelas_id' => 'required',
            'email' => 'required|email:dns|unique:siswa',
            'password' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $validate['nama_siswa'] = $validate['nama'];
        $validate['password'] = Hash::make($validate['password']);

        $tokens = [
            'token' => Str::random(40),
            'email' => $validate['email'],
            'key' => 'aktivasi',
            'role' => 3,
        ];
        $details = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'token' => $tokens['token']
        ];
        Mail::to("$request->email")->send(new VerifikasiAkun($details));
        $siswa = Siswa::create($validate);
        Token::create($tokens);
        $siswa->update(['is_active' => 0]);
        return redirect('/login')->with([
            'pesanRegis' => "Registrasi berhasil silahkan cek email untuk validasi",
            'nama' => $request->nama,
            'password' => $request->password,
            'token' => $tokens['token'],
            'email' => $request->email
        ]);
    }

    public function emailSend(Request $request)
    {
        $details = [
            'nama' => $request->nama,
            'password' => $request->password,
            'token' => $request->token,
            'email' => $request->email
        ];
        Mail::to("$request->email")->send(new VerifikasiAkun($details));
        return redirect('/login')->with([
            'pesanRegis' => "Email berhasil di kirim ulang silahkan cek email untuk validasi",
            'nama' => $request->nama,
            'password' => $request->password,
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    public function aktivasi(Token $token)
    {
        if ($token->created_at->diffInMinutes() > 60) {

            if ($token->role == 2) {
                Guru::where('email', $token->email)
                    ->delete();
            } else {
                Siswa::where('email', $token->email)
                    ->delete();
            }
            Token::where('id', $token->id)
                ->delete();

            return redirect('/login')->with('pesan', "
                <script>
                    swal({
                        title: 'Token Expired!',
                        text: 'token sudah kadaluarsa, silahkan lakukan daftar ulang',
                        type: 'warning',
                        padding: '2em'
                    })
                </script>
            ");
        }

        if ($token->role == 2) {
            Guru::where('email', $token->email)
                ->update(['is_active' => 1]);
        } else {
            Siswa::where('email', $token->email)
                ->update(['is_active' => 1]);
        }

        Token::where('id', $token->id)
            ->delete();

        return redirect('/login')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Akun sudah aktif, silahkan login',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function recovery()
    {
        $admin = Admin::all();
        if ($admin->count() == 0) {
            return redirect('/login')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'Akun admin belum dibuat',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return view('auth.recovery', [
            'title' => 'Lupa Password'
        ]);
    }
    public function recovery_(Request $request)
    {
        $user = null;
        $admin = Admin::firstWhere('email', $request->input('email'));
        if ($admin) {
            $user = $admin;
        }
        $guru = Guru::firstWhere('email', $request->input('email'));
        if ($guru) {
            $user = $guru;
        }
        $siswa = Siswa::firstWhere('email', $request->input('email'));
        if ($siswa) {
            $user = $siswa;
        }

        if ($user == null) {
            return redirect('/recovery')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'email tidak ditemukan, silahkan coba lagi',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }

        $tokens = [
            'token' => Str::random(40),
            'email' => $request->email,
            'key' => 'password',
            'role' => $user->role
        ];
        $details = [
            'email' => $request->email,
            'token' => $tokens['token']
        ];
        Mail::to("$request->email")->send(new ForgotPassword($details));
        Token::create($tokens);

        return redirect('/login')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'silahkan buka email untuk validasi lupa password',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
    }
    public function change_password(Token $token)
    {
        if ($token->created_at->diffInMinutes() > 60) {
            Token::where('id', $token->id)
                ->delete();

            return redirect('/login')->with('pesan', "
                <script>
                    swal({
                        title: 'Token Expired!',
                        text: 'token sudah kadaluarsa, silahkan ulangi proses',
                        type: 'warning',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return view('auth.change-password', [
            'token' => $token
        ]);
    }
    public function change_password_(Token $token, Request $request)
    {
        $password = bcrypt($request->password);
        if ($token->role == 1) {
            Admin::where('email', $token->email)
                ->update(['password' => $password]);
        }
        if ($token->role == 2) {
            Guru::where('email', $token->email)
                ->update(['password' => $password]);
        }
        if ($token->role == 3) {
            Siswa::where('email', $token->email)
                ->update(['password' => $password]);
        }
        Token::where('id', $token->id)
            ->delete();

        return redirect('/login')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'password telah di ubah, silahkan login',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function logout(Request $request)
    {
        $request->session()->remove('id');
        $request->session()->remove('email');
        $request->session()->remove('role');

        return redirect('/login')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'Anda telah logout',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");

        return redirect('/login');
    }

    public  function passwordRequest()
    {
        return view('auth.passwordRequest', [
            "title" => "Password Request"
        ]);
    }

    public  function sendPasswordRequest(Request $request)
    {

        $details = [
            'token' => $request->nama,
        ];
        Mail::to("$request->email")->send(new ForgotPassword($details));
        return view('auth.passwordRequest', [
            "title" => "Password Request"
        ]);
    }
}
