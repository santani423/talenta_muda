# TALENTA MUDA — Dokumentasi Teknis & Manual Book Developer

> **Versi:** 1.0.0 | **Framework:** Laravel 10 | **PHP:** 8.1+ | **Database:** MySQL
> **Terakhir diperbarui:** 2026-05-30

---

## Daftar Isi

1. [Gambaran Umum Aplikasi](#1-gambaran-umum-aplikasi)
2. [Tujuan dan Ruang Lingkup Sistem](#2-tujuan-dan-ruang-lingkup-sistem)
3. [Teknologi yang Digunakan](#3-teknologi-yang-digunakan)
4. [Struktur Direktori](#4-struktur-direktori)
5. [Cara Instalasi & Menjalankan Project](#5-cara-instalasi--menjalankan-project)
6. [Konfigurasi Environment (.env)](#6-konfigurasi-environment-env)
7. [Role dan Hak Akses Pengguna](#7-role-dan-hak-akses-pengguna)
8. [Struktur Database & Relasi Antar Tabel](#8-struktur-database--relasi-antar-tabel)
9. [Mekanisme Autentikasi & Otorisasi](#9-mekanisme-autentikasi--otorisasi)
10. [Penjelasan Modul & Halaman Beserta URL](#10-penjelasan-modul--halaman-beserta-url)
11. [Alur Bisnis Utama Sistem](#11-alur-bisnis-utama-sistem)
12. [Flow Transaksi Ujian](#12-flow-transaksi-ujian)
13. [Struktur Frontend & Backend](#13-struktur-frontend--backend)
14. [Daftar API Endpoint](#14-daftar-api-endpoint)
15. [Integrasi Layanan Eksternal](#15-integrasi-layanan-eksternal)
16. [Seeder, Migration & Data Dummy](#16-seeder-migration--data-dummy)
17. [Laporan yang Tersedia dalam Sistem](#17-laporan-yang-tersedia-dalam-sistem)
18. [Jobs, Queue, Scheduler & Event](#18-jobs-queue-scheduler--event)
19. [Konvensi Penulisan Kode](#19-konvensi-penulisan-kode)
20. [Panduan Deployment](#20-panduan-deployment)
21. [Daftar Fitur Selesai & Dalam Pengembangan](#21-daftar-fitur-selesai--dalam-pengembangan)
22. [Troubleshooting & Solusi Umum](#22-troubleshooting--solusi-umum)
23. [Catatan Teknis & Best Practice](#23-catatan-teknis--best-practice)

---

## 1. Gambaran Umum Aplikasi

**Talenta Muda** adalah sistem manajemen pembelajaran (Learning Management System / LMS) berbasis web yang dikembangkan menggunakan Laravel 10. Sistem ini dirancang khusus untuk mendukung proses **penilaian bakat, psikometri, dan ujian akademik** bagi siswa dengan fitur lengkap untuk guru dan administrator.

Aplikasi ini mencakup tiga aktor utama:
- **Admin** — mengelola seluruh data master dan pengguna sistem.
- **Guru** — membuat materi, tugas, ujian, dan mengelola penilaian.
- **Siswa** — mengakses materi, mengerjakan tugas, dan mengikuti ujian.

Keunikan sistem ini dibandingkan LMS umum adalah integrasi modul **asesmen psikometri** yang meliputi: MMPI, kuesioner berbasis facet, kalkulasi T-Score, klasifikasi IQ, dan interpretasi hasil secara otomatis.

---

## 2. Tujuan dan Ruang Lingkup Sistem

### Tujuan
- Memfasilitasi proses pembelajaran daring antara guru dan siswa.
- Menyediakan platform ujian multi-tipe yang terstruktur dan aman.
- Mengotomasi penilaian dan interpretasi hasil asesmen psikometri.
- Menyediakan laporan akademik yang dapat dicetak dan diekspor.

### Ruang Lingkup
| Fitur | Termasuk |
|---|---|
| Manajemen pengguna (Admin, Guru, Siswa) | ✅ |
| Manajemen kelas dan mata pelajaran | ✅ |
| Materi pembelajaran dengan rich-text editor | ✅ |
| Tugas dengan tenggat waktu | ✅ |
| Ujian Pilihan Ganda (PG) | ✅ |
| Ujian Essay | ✅ |
| Ujian Visual | ✅ |
| Ujian Kuesioner / Psikometri | ✅ |
| Simulator Ujian | ✅ |
| Merge Ujian (gabungan soal) | ✅ |
| Bank Soal | ✅ |
| Asesmen MMPI | ✅ |
| Kalkulasi T-Score & IQ | ✅ |
| Laporan nilai (PDF & Excel) | ✅ |
| Notifikasi email | ✅ |
| Chat dalam sistem | ✅ |
| Import/Export data pengguna | ✅ |

---

## 3. Teknologi yang Digunakan

### Backend
| Teknologi | Versi | Fungsi |
|---|---|---|
| PHP | 8.1+ | Bahasa pemrograman server |
| Laravel | 10.10 | Framework utama |
| MySQL | 8.0+ | Database |
| Laravel Sanctum | 3.3 | Autentikasi API token |
| Maatwebsite Excel | 3.1 | Import/export Excel |
| DomPDF (barryvdh) | 3.1 | Generate file PDF |
| Guzzle HTTP | 7.2 | HTTP client untuk integrasi eksternal |

### Frontend
| Teknologi | Fungsi |
|---|---|
| Blade Templating | Template engine Laravel |
| Vite 5 | Build tool dan bundler aset |
| Axios | HTTP request dari sisi klien |
| Summernote | WYSIWYG / rich-text editor |

### Development & Tools
| Teknologi | Fungsi |
|---|---|
| PHPUnit 10 | Unit testing |
| Laravel Pint | Code style fixer |
| Laravel Sail | Lingkungan Docker |
| Faker PHP | Data dummy untuk testing |

---

## 4. Struktur Direktori

```
TalentaMuda/
│
├── app/
│   ├── Console/
│   │   └── Kernel.php                  # Scheduler & artisan commands
│   ├── Exceptions/
│   │   └── Handler.php                 # Global exception handling
│   ├── Exports/                        # Class export Excel (Maatwebsite)
│   ├── Http/
│   │   ├── Controllers/                # 39 controller (lihat daftar lengkap di Bagian 10)
│   │   └── Middleware/                 # 12 middleware (auth, role, dsb)
│   ├── Imports/                        # Class import Excel
│   ├── Mail/                           # Mailable class untuk email
│   ├── Models/                         # 54 Eloquent model
│   ├── Providers/                      # Service provider
│   ├── View/                           # View composer / share data
│   └── helpers.php                     # Helper function global
│
├── bootstrap/                          # Bootstrap aplikasi Laravel
│
├── config/
│   ├── app.php                         # Konfigurasi aplikasi (nama, timezone, locale)
│   ├── auth.php                        # Guard dan provider autentikasi
│   ├── database.php                    # Koneksi database
│   ├── mail.php                        # Konfigurasi SMTP email
│   ├── excel.php                       # Konfigurasi Maatwebsite Excel
│   ├── filesystems.php                 # Konfigurasi storage
│   ├── sanctum.php                     # Konfigurasi API token
│   ├── queue.php                       # Driver queue
│   ├── session.php                     # Konfigurasi sesi
│   └── cors.php                        # CORS policy
│
├── database/
│   ├── migrations/                     # 57 file migration
│   └── seeders/                        # 38 file seeder
│
├── public/
│   ├── index.php                       # Entry point aplikasi
│   ├── assets/                         # Aset publik (CSS, JS, gambar)
│   └── storage/                        # Symlink ke storage/app/public
│
├── resources/
│   ├── views/                          # 80+ Blade template
│   │   ├── admin/                      # View untuk admin
│   │   ├── guru/                       # View untuk guru
│   │   ├── siswa/                      # View untuk siswa
│   │   ├── auth/                       # View login & register
│   │   ├── components/                 # Reusable Blade components
│   │   ├── emails/                     # Template email
│   │   ├── ekspor/                     # Template export PDF/Excel
│   │   ├── pdf/                        # Template cetak PDF
│   │   ├── template/                   # Layout utama (main.blade.php, dll)
│   │   └── errors/                     # Halaman error (403, 404)
│   └── js/                             # Entry point JavaScript (Vite)
│
├── routes/
│   ├── web.php                         # Seluruh route web (280+ baris)
│   └── api.php                         # Route API (minimal, 2 endpoint)
│
├── storage/
│   ├── app/public/                     # File upload pengguna
│   └── logs/                           # Log aplikasi
│
├── tests/                              # Unit & feature test
│
├── .env                                # Konfigurasi environment (tidak di-commit)
├── .env.example                        # Template .env
├── artisan                             # CLI Laravel
├── composer.json                       # Dependensi PHP
├── package.json                        # Dependensi Node.js
└── vite.config.js                      # Konfigurasi Vite
```

---

## 5. Cara Instalasi & Menjalankan Project

### Prasyarat
- PHP >= 8.1 dengan ekstensi: `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- Composer >= 2.x
- Node.js >= 18.x dan NPM
- MySQL >= 8.0
- Web server: Apache / Nginx (atau PHP built-in server untuk development)

### Langkah Instalasi

**1. Clone repository**
```bash
git clone <repository-url> TalentaMuda
cd TalentaMuda
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Install dependensi Node.js**
```bash
npm install
```

**4. Salin dan konfigurasi file environment**
```bash
cp .env.example .env
# Edit file .env sesuai konfigurasi lokal Anda (lihat Bagian 6)
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Buat database MySQL**
```sql
CREATE DATABASE talenta_muda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**7. Jalankan migration dan seeder**
```bash
# Jalankan semua migration
php artisan migrate

# Jalankan seeder untuk data awal (termasuk data MMPI, kuesioner, dll)
php artisan db:seed
```

**8. Buat symlink storage**
```bash
php artisan storage:link
```

**9. Build aset frontend**
```bash
# Untuk development (dengan hot-reload)
npm run dev

# Untuk production
npm run build
```

**10. Jalankan server development**
```bash
php artisan serve
# Aplikasi berjalan di http://localhost:8000
```

> **Catatan:** Pada production yang menggunakan Apache dengan subfolder (misal `/talenta-muda`), pastikan `APP_URL` di `.env` sudah disesuaikan dan `.htaccess` di folder `public/` aktif.

### Instalasi via Halaman Web

Sistem menyediakan route `/install` untuk instalasi awal via browser. Akses `http://localhost/talenta-muda/install` dan ikuti wizard instalasi yang tersedia.

---

## 6. Konfigurasi Environment (.env)

Berikut adalah seluruh variabel environment yang digunakan beserta penjelasannya:

```dotenv
# ─────────────────────────────────────────
# APLIKASI
# ─────────────────────────────────────────
APP_NAME=TALENTA_MUDA          # Nama aplikasi (tampil di UI)
APP_ENV=local                  # Lingkungan: local | staging | production
APP_KEY=                       # Generate dengan: php artisan key:generate
APP_DEBUG=true                 # true hanya di development
APP_URL=http://localhost/talenta-muda  # URL dasar aplikasi

# Lokalisasi
TIMEZONE=Asia/Jakarta          # Zona waktu server
LOCALE=id                      # Bahasa default (Indonesia)

# ─────────────────────────────────────────
# DATABASE
# ─────────────────────────────────────────
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talenta_muda
DB_USERNAME=root
DB_PASSWORD=

# ─────────────────────────────────────────
# CACHE & SESSION
# ─────────────────────────────────────────
CACHE_DRIVER=file              # Opsi: file | redis | database
SESSION_DRIVER=file            # Opsi: file | database | redis | cookie
SESSION_LIFETIME=120           # Durasi sesi dalam menit
QUEUE_CONNECTION=sync          # Opsi: sync | database | redis

# ─────────────────────────────────────────
# EMAIL (SMTP)
# ─────────────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# ─────────────────────────────────────────
# FILESYSTEM
# ─────────────────────────────────────────
FILESYSTEM_DISK=local          # Disk default untuk upload file
```

> **Penting untuk Production:**
> - Ganti `APP_DEBUG=false`
> - Ganti `APP_ENV=production`
> - Gunakan password database yang kuat
> - Gunakan App Password Gmail (bukan password akun biasa) untuk `MAIL_PASSWORD`

---

## 7. Role dan Hak Akses Pengguna

Sistem menggunakan field `role` pada tabel `users` untuk membedakan hak akses:

| Role | Nilai | Tabel Profil | Middleware Route |
|---|---|---|---|
| Admin | `1` | `admins` | `is_admin` |
| Guru | `2` | `guru` | `is_guru` |
| Siswa | `3` | `siswa` | `is_siswa` |

### Admin
- Mengelola seluruh data master: siswa, guru, kelas, mata pelajaran.
- Import/export data pengguna via Excel.
- Mengatur relasi guru-kelas dan guru-mata pelajaran.
- Konfigurasi pengaturan email SMTP.
- Melihat seluruh laporan sistem.

### Guru
- Membuat dan mengelola materi pembelajaran.
- Membuat dan menilai tugas siswa.
- Membuat ujian dengan berbagai tipe soal.
- Mengelola bank soal dan merge ujian.
- Membuat instruksi ujian.
- Melihat laporan hasil ujian siswa.
- Mengakses laporan nilai per kelas dan per siswa.

### Siswa
- Melihat materi yang diunggah guru.
- Mengerjakan dan mengumpulkan tugas.
- Mengikuti ujian sesuai jadwal yang ditentukan guru.
- Melihat hasil dan nilai ujian.
- Mengikuti asesmen psikometri (kuesioner, MMPI).
- Melihat T-Score dan hasil interpretasi psikometri.

---

## 8. Struktur Database & Relasi Antar Tabel

### Diagram Relasi (ERD Ringkas)

```
users (id, name, email, password, role)
  │
  ├──[role=1]──► admins (id, user_id, ...)
  │
  ├──[role=2]──► guru (id, user_id, nama_guru, nip, ...)
  │                │
  │                ├──► gurukelas (guru_id, kelas_id)    ◄──► kelas
  │                ├──► gurumapel (guru_id, mapel_id)    ◄──► mapel
  │                ├──► materi (id, guru_id, kelas_id, mapel_id, ...)
  │                ├──► tugas (id, guru_id, kelas_id, mapel_id, ...)
  │                └──► ujian (id, guru_id, kelas_id, mapel_id, jenis, ...)
  │                          │
  │                          ├──► detail_ujian        (soal PG)
  │                          ├──► detail_essay        (soal Essay)
  │                          ├──► detail_visuals      (soal Visual)
  │                          ├──► detail_kuisoners    (soal Kuesioner)
  │                          ├──► waktu_ujian         (jadwal per siswa)
  │                          └──► intruksi_ujians     (instruksi ujian)
  │
  └──[role=3]──► siswa (id, user_id, nama_siswa, nis, kelas_id, tgl_lahir, ...)
                   │
                   ├──► tugas_siswa        (pengumpulan tugas)
                   ├──► waktu_ujian        (jadwal & status ujian)
                   ├──► pg_siswa           (jawaban PG)
                   ├──► jawaban_essays     (jawaban Essay)
                   ├──► visual_siswas      (jawaban Visual)
                   └──► kuesioner_siswas   (jawaban Kuesioner/MMPI)
```

### Daftar Tabel Lengkap (57 Tabel)

#### Tabel Pengguna & Autentikasi
| Tabel | Fungsi |
|---|---|
| `users` | Data login seluruh pengguna (email, password, role) |
| `admins` | Profil admin |
| `guru` | Profil guru (NIP, nama, kontak, dll) |
| `siswa` | Profil siswa (NIS, nama, kelas, tanggal lahir, dll) |
| `tokens` | Token aktivasi/verifikasi akun |
| `personal_access_tokens` | Token Sanctum untuk API |
| `password_reset_tokens` | Token reset password |

#### Tabel Struktur Akademik
| Tabel | Fungsi |
|---|---|
| `kelas` | Data kelas/rombel (nama, status aktif) |
| `mapel` | Data mata pelajaran |
| `gurukelas` | Relasi many-to-many guru ↔ kelas |
| `gurumapel` | Relasi many-to-many guru ↔ mapel |

#### Tabel Konten Pembelajaran
| Tabel | Fungsi |
|---|---|
| `materi` | Materi pembelajaran (teks rich-text, lampiran) |
| `tugas` | Data tugas (deadline, instruksi) |
| `tugas_siswa` | Pengumpulan tugas oleh siswa |
| `files` | File yang diunggah via Summernote |

#### Tabel Ujian
| Tabel | Fungsi |
|---|---|
| `ujian` | Header ujian (kode, nama, jenis, guru, kelas, mapel, durasi) |
| `waktu_ujian` | Jadwal ujian per siswa (start, end, status) |
| `intruksi_ujians` | Instruksi / panduan sebelum ujian |
| `merge_ujian` | Konfigurasi merge beberapa ujian |
| `relasi_ujian_merge` | Relasi detail untuk merge ujian |

#### Tabel Soal Ujian (berdasarkan tipe)
| Tabel | Fungsi |
|---|---|
| `detail_ujian` | Soal Pilihan Ganda dalam ujian |
| `detail_essay` | Soal Essay dalam ujian |
| `detail_visuals` | Soal Visual dalam ujian |
| `detail_kuisoners` | Soal Kuesioner dalam ujian |
| `detail_kuisoner_facets` | Mapping soal kuesioner ke facet psikologi |
| `detail_kuisoner_sekalas` | Mapping soal kuesioner ke skala |

#### Tabel Bank Soal
| Tabel | Fungsi |
|---|---|
| `bank_soal` | Header bank soal |
| `detail_bank_pg` | Soal PG dalam bank soal |
| `detail_bank_essay` | Soal Essay dalam bank soal |

#### Tabel Jawaban Siswa
| Tabel | Fungsi |
|---|---|
| `pg_siswa` | Jawaban PG siswa (detail_ujian_id, jawaban, nilai) |
| `jawaban_essays` | Jawaban essay siswa (teks, nilai guru) |
| `essay_siswa` | Relasi siswa ↔ ujian essay |
| `visual_siswas` | Jawaban soal visual siswa |
| `kuesioner_siswas` | Jawaban kuesioner/MMPI siswa |

#### Tabel Simulator
| Tabel | Fungsi |
|---|---|
| `simulasi_ujian_pg` | Data simulator soal PG |
| `simulasi_ujian_visuals` | Data simulator soal visual |
| `simulasi_ujian_essays` | Data simulator soal essay |

#### Tabel Psikometri & Asesmen
| Tabel | Fungsi |
|---|---|
| `facets` | Facet psikologi (kode, deskripsi) |
| `sekalas` | Skala penilaian kuesioner |
| `jenis_jawaban_kuesioners` | Tipe jawaban kuesioner |
| `detail_jawaban_kuesioners` | Pilihan jawaban kuesioner |
| `mmpis` | Data soal dan konfigurasi MMPI |
| `interpretasis` | Interpretasi hasil asesmen |
| `domains` | Domain asesmen psikologi |
| `domin_facets` | Relasi domain ↔ facet |
| `klasifikasi_iqs` | Tabel klasifikasi skor IQ |
| `t_scores` | Data T-Score norma |
| `skor_kalenders` | Kalender penilaian / skor |
| `type_essays` | Tipe soal essay |

#### Tabel Pendukung
| Tabel | Fungsi |
|---|---|
| `notifications` | Notifikasi dalam sistem |
| `userchat` | Pesan chat antar pengguna |
| `email_settings` | Konfigurasi SMTP (tersimpan di DB) |
| `jobs` | Queue job Laravel |
| `failed_jobs` | Queue job yang gagal |

---

## 9. Mekanisme Autentikasi & Otorisasi

### Alur Login
1. Pengguna mengakses `GET /login`.
2. Mengisi form email + password → `POST /login`.
3. `AuthController::login()` memverifikasi kredensial via `Auth::attempt()`.
4. Jika berhasil, sistem memeriksa `role` pada tabel `users`:
   - Role `1` → redirect ke `/admin/dashboard`
   - Role `2` → redirect ke `/guru/dashboard`
   - Role `3` → redirect ke `/siswa/dashboard`
5. Jika gagal, kembali ke form dengan pesan error.

### Middleware Role
Setiap grup route dilindungi middleware role yang memeriksa nilai `auth()->user()->role`:

```php
// Contoh pengecekan di middleware IsGuru.php
if (Auth::check() && Auth::user()->role == 2) {
    return $next($request);
}
return redirect('/login');
```

| Middleware | File | Kondisi Akses |
|---|---|---|
| `is_admin` | `IsAdmin.php` | `role == 1` |
| `is_guru` | `IsGuru.php` | `role == 2` |
| `is_siswa` | `IsSiswa.php` | `role == 3` |

### Aktivasi Akun
- Saat admin mendaftarkan guru/siswa baru, sistem mengirim email verifikasi dengan token unik.
- Token disimpan di tabel `tokens`.
- Pengguna mengklik link di email → `GET /aktivasi/{token}` → akun aktif.

### Reset Password
1. Guru/Siswa mengakses `GET /recovery`.
2. Memasukkan email → `POST /recovery`.
3. Sistem mengirim email dengan link reset menggunakan `password_reset_tokens`.
4. Pengguna klik link → `GET /reset-password/{token}` → set password baru.

### API Authentication (Sanctum)
Untuk endpoint API (route `api.php`), sistem menggunakan Laravel Sanctum dengan token Bearer. Endpoint API saat ini minimal dan digunakan untuk keperluan internal AJAX.

---

## 10. Penjelasan Modul & Halaman Beserta URL

### Modul Publik (Tanpa Login)

| URL | Method | Fungsi |
|---|---|---|
| `/` | GET | Landing page / halaman utama |
| `/login` | GET, POST | Form dan proses login |
| `/register` | GET, POST | Form dan proses registrasi |
| `/install` | GET, POST | Wizard instalasi awal sistem |
| `/recovery` | GET, POST | Form permintaan reset password |
| `/reset-password/{token}` | GET, POST | Form set password baru |
| `/aktivasi/{token}` | GET | Aktivasi akun via email |

---

### Modul Admin (Prefix: `/admin`, Middleware: `is_admin`)

#### Dashboard & Profil
| URL | Method | Fungsi |
|---|---|---|
| `/admin/dashboard` | GET | Dashboard admin dengan statistik sistem |
| `/admin/profile` | GET | Halaman profil admin |
| `/admin/profile/update` | POST | Update data profil admin |
| `/admin/password/update` | POST | Update password admin |

#### Manajemen Siswa
| URL | Method | Fungsi |
|---|---|---|
| `/admin/siswa` | GET | Daftar seluruh siswa |
| `/admin/siswa/tambah` | GET | Form tambah siswa baru |
| `/admin/siswa/store` | POST | Simpan data siswa baru |
| `/admin/siswa/edit/{id}` | GET | Form edit data siswa |
| `/admin/siswa/update/{id}` | POST | Update data siswa |
| `/admin/siswa/delete/{id}` | POST | Hapus data siswa |
| `/admin/siswa/import` | POST | Import siswa dari file Excel |
| `/admin/siswa/export` | GET | Export daftar siswa ke Excel |

#### Manajemen Guru
| URL | Method | Fungsi |
|---|---|---|
| `/admin/guru` | GET | Daftar seluruh guru |
| `/admin/guru/tambah` | GET | Form tambah guru baru |
| `/admin/guru/store` | POST | Simpan data guru baru |
| `/admin/guru/edit/{id}` | GET | Form edit data guru |
| `/admin/guru/update/{id}` | POST | Update data guru |
| `/admin/guru/delete/{id}` | POST | Hapus data guru |
| `/admin/guru/import` | POST | Import guru dari file Excel |
| `/admin/guru/export` | GET | Export daftar guru ke Excel |
| `/admin/guru/relasi` | GET | Daftar relasi guru-kelas-mapel |
| `/admin/guru/relasi/tambah` | GET, POST | Tambah relasi guru ↔ kelas |
| `/admin/guru/relasi/mapel/tambah` | GET, POST | Tambah relasi guru ↔ mapel |

#### Manajemen Kelas & Mata Pelajaran
| URL | Method | Fungsi |
|---|---|---|
| `/admin/kelas` | GET | Daftar kelas |
| `/admin/kelas/tambah` | GET, POST | Tambah kelas baru |
| `/admin/kelas/edit/{id}` | GET, POST | Edit kelas |
| `/admin/kelas/delete/{id}` | POST | Hapus kelas |
| `/admin/kelas/toggle/{id}` | POST | Toggle status aktif kelas |
| `/admin/mapel` | GET | Daftar mata pelajaran |
| `/admin/mapel/tambah` | GET, POST | Tambah mata pelajaran baru |
| `/admin/mapel/edit/{id}` | GET, POST | Edit mata pelajaran |
| `/admin/mapel/delete/{id}` | POST | Hapus mata pelajaran |

---

### Modul Guru (Prefix: `/guru`, Middleware: `is_guru`)

#### Dashboard & Profil
| URL | Method | Fungsi |
|---|---|---|
| `/guru/dashboard` | GET | Dashboard guru |
| `/guru/profile` | GET | Profil guru |
| `/guru/profile/update` | POST | Update profil guru |
| `/guru/password/update` | POST | Update password guru |

#### Manajemen Materi
| URL | Method | Fungsi |
|---|---|---|
| `/guru/materi` | GET | Daftar materi yang dibuat guru |
| `/guru/materi/create` | GET | Form buat materi baru |
| `/guru/materi` | POST | Simpan materi baru |
| `/guru/materi/{kode}` | GET | Detail materi |
| `/guru/materi/{kode}/edit` | GET | Form edit materi |
| `/guru/materi/{kode}` | PUT | Update materi |
| `/guru/materi/{kode}` | DELETE | Hapus materi |

#### Manajemen Tugas
| URL | Method | Fungsi |
|---|---|---|
| `/guru/tugas` | GET | Daftar tugas yang dibuat guru |
| `/guru/tugas/create` | GET | Form buat tugas baru |
| `/guru/tugas/store` | POST | Simpan tugas baru |
| `/guru/tugas/{kode}` | GET | Detail tugas beserta daftar pengumpulan siswa |
| `/guru/tugas/{kode}/edit` | GET | Form edit tugas |
| `/guru/tugas/{kode}/update` | POST | Update tugas |
| `/guru/tugas/{kode}/delete` | POST | Hapus tugas |
| `/guru/tugas/{kode}/nilai/{siswa_id}` | POST | Beri nilai tugas siswa |
| `/guru/tugas/{kode}/cetak` | GET | Cetak rekap nilai tugas (PDF) |

#### Manajemen Ujian (Pilihan Ganda)
| URL | Method | Fungsi |
|---|---|---|
| `/guru/ujian` | GET | Daftar ujian yang dibuat guru |
| `/guru/ujian/create` | GET | Form buat ujian PG baru |
| `/guru/ujian/store` | POST | Simpan ujian PG baru |
| `/guru/ujian/{kode}` | GET | Detail ujian (daftar soal) |
| `/guru/ujian/{kode}/edit` | GET, POST | Edit ujian PG |
| `/guru/ujian/{kode}/delete` | POST | Hapus ujian |
| `/guru/ujian/{kode}/show-siswa` | GET | Lihat hasil ujian PG per siswa |
| `/guru/ujian/{kode}/cetak-pg` | GET | Cetak soal PG (PDF) |

#### Manajemen Ujian (Essay)
| URL | Method | Fungsi |
|---|---|---|
| `/guru/ujian/essay/create` | GET | Form buat ujian Essay |
| `/guru/ujian/essay/store` | POST | Simpan ujian Essay |
| `/guru/ujian/{kode}/essay` | GET | Detail ujian Essay |
| `/guru/ujian/{kode}/essay/edit` | GET, POST | Edit ujian Essay |
| `/guru/ujian/{kode}/essay/siswa` | GET | Lihat jawaban Essay siswa |
| `/guru/ujian/{kode}/essay/nilai` | POST | Beri nilai jawaban Essay |
| `/guru/ujian/{kode}/cetak-essay` | GET | Cetak soal Essay (PDF) |

#### Manajemen Ujian (Visual)
| URL | Method | Fungsi |
|---|---|---|
| `/guru/ujian/visual/create` | GET | Form buat ujian Visual |
| `/guru/ujian/visual/store` | POST | Simpan ujian Visual |
| `/guru/ujian/{kode}/visual` | GET | Detail ujian Visual |
| `/guru/ujian/{kode}/visual/edit` | GET, POST | Edit ujian Visual |

#### Manajemen Ujian (Kuesioner / Psikometri)
| URL | Method | Fungsi |
|---|---|---|
| `/guru/ujian/kuesioner/create` | GET | Form buat ujian Kuesioner |
| `/guru/ujian/kuesioner/store` | POST | Simpan ujian Kuesioner |
| `/guru/ujian/{kode}/kuesioner` | GET | Detail ujian Kuesioner |
| `/guru/ujian/{kode}/kuesioner/edit` | GET, POST | Edit ujian Kuesioner |
| `/guru/ujian/{kode}/kuesioner/siswa` | GET | Lihat hasil kuesioner siswa |

#### Manajemen Ujian (Simulator)
| URL | Method | Fungsi |
|---|---|---|
| `/guru/ujian/simulator-pg/create` | GET, POST | Buat simulator ujian PG |
| `/guru/ujian/intruksi/create` | GET, POST | Buat instruksi ujian |

#### Laporan Ujian Siswa
| URL | Method | Fungsi |
|---|---|---|
| `/guru/laporan/ujian-siswa` | GET | Laporan hasil ujian per siswa dan per ujian |

#### Bank Soal
| URL | Method | Fungsi |
|---|---|---|
| `/guru/bank-soal` | GET | Daftar bank soal |
| `/guru/bank-soal/create` | GET, POST | Buat bank soal PG baru |
| `/guru/bank-soal/{kode}` | GET | Detail bank soal PG |
| `/guru/bank-soal/{kode}/edit` | GET, POST | Edit bank soal PG |
| `/guru/bank-soal/{kode}/delete` | POST | Hapus bank soal |
| `/guru/bank-soal/essay/create` | GET, POST | Buat bank soal Essay |
| `/guru/bank-soal/{kode}/essay` | GET | Detail bank soal Essay |
| `/guru/bank-soal/{kode}/essay/edit` | GET, POST | Edit bank soal Essay |

#### Merge Ujian
| URL | Method | Fungsi |
|---|---|---|
| `/guru/merge-ujian` | GET | Daftar konfigurasi merge ujian |
| `/guru/merge-ujian/{id}` | GET | Detail merge ujian |
| `/guru/merge-ujian/{id}/edit` | GET, POST | Edit konfigurasi merge ujian |

---

### Modul Siswa (Prefix: `/siswa`, Middleware: `is_siswa`)

#### Dashboard & Profil
| URL | Method | Fungsi |
|---|---|---|
| `/siswa/dashboard` | GET | Dashboard siswa |
| `/siswa/profile` | GET | Profil siswa |
| `/siswa/profile/update` | POST | Update profil siswa |
| `/siswa/password/update` | POST | Update password siswa |

#### Materi
| URL | Method | Fungsi |
|---|---|---|
| `/siswa/materi` | GET | Daftar materi sesuai kelas siswa |
| `/siswa/materi/{kode}` | GET | Detail / baca materi |

#### Tugas
| URL | Method | Fungsi |
|---|---|---|
| `/siswa/tugas` | GET | Daftar tugas yang diberikan |
| `/siswa/tugas/{kode}` | GET | Detail tugas |
| `/siswa/tugas/{kode}/kerjakan` | GET | Halaman pengerjaan tugas |
| `/siswa/tugas/{kode}/submit` | POST | Kumpulkan jawaban tugas |
| `/siswa/tugas/{kode}/edit` | GET, POST | Edit jawaban tugas (sebelum deadline) |

#### Ujian
| URL | Method | Fungsi |
|---|---|---|
| `/siswa/ujian` | GET | Daftar ujian aktif untuk siswa |
| `/siswa/ujian/{kode}` | GET | Detail/info ujian sebelum mulai |
| `/siswa/ujian/{kode}/slide` | GET | Tampilan slide instruksi ujian |
| `/siswa/ujian/{kode}/intruksi` | GET | Halaman instruksi ujian |
| `/siswa/ujian/{kode}/mulai` | POST | Mulai ujian (catat waktu start) |
| `/siswa/ujian/{kode}/pg/jawab` | POST | Kirim jawaban soal PG |
| `/siswa/ujian/{kode}/essay/jawab` | POST | Kirim jawaban soal Essay |
| `/siswa/ujian/{kode}/visual/jawab` | POST | Kirim jawaban soal Visual |
| `/siswa/ujian/{kode}/kuesioner/jawab` | POST | Kirim jawaban Kuesioner |
| `/siswa/ujian/{kode}/waktu` | GET | Cek sisa waktu ujian (AJAX) |
| `/siswa/ujian/{kode}/selesai` | POST | Tandai ujian selesai |

#### Hasil Ujian
| URL | Method | Fungsi |
|---|---|---|
| `/siswa/hasil-ujian/{kode}` | GET | Lihat rekap hasil ujian |
| `/siswa/hasil-ujian/{kode}/pg` | GET | Rincian jawaban PG |
| `/siswa/hasil-ujian/{kode}/essay` | GET | Rincian jawaban Essay |
| `/siswa/hasil-ujian/{kode}/visual` | GET | Rincian jawaban Visual |
| `/siswa/hasil-ujian/{kode}/kuesioner` | GET | Rincian hasil kuesioner |

#### T-Score
| URL | Method | Fungsi |
|---|---|---|
| `/tscore/{siswa_id}` | GET | Lihat T-Score siswa |
| `/tscore/{siswa_id}/print` | GET | Cetak laporan T-Score (PDF) |

---

### Modul Summernote (Upload File Editor)
| URL | Method | Fungsi |
|---|---|---|
| `/summernote/upload` | POST | Upload gambar/file dari editor Summernote |
| `/summernote/delete` | POST | Hapus file yang diunggah via Summernote |

---

## 11. Alur Bisnis Utama Sistem

### A. Alur Onboarding Pengguna Baru

```
Admin login
    └── Buat Kelas baru
    └── Buat Mata Pelajaran (Mapel)
    └── Tambah Guru → sistem kirim email aktivasi
    └── Tambah Siswa → sistem kirim email aktivasi → assign ke kelas
    └── Atur relasi Guru ↔ Kelas
    └── Atur relasi Guru ↔ Mapel

Guru menerima email → klik link aktivasi → set password → login
Siswa menerima email → klik link aktivasi → set password → login
```

### B. Alur Pembelajaran (Materi & Tugas)

```
Guru login
    └── Buat Materi (pilih kelas & mapel, tulis konten rich-text)
        └── Siswa di kelas tersebut bisa melihat materi
    └── Buat Tugas (pilih kelas & mapel, tulis instruksi, set deadline)
        └── Siswa mengerjakan tugas → upload jawaban → submit
        └── Guru menilai tugas siswa → input nilai
```

### C. Alur Pembuatan Ujian

```
Guru login
    └── Pilih tipe ujian: PG / Essay / Visual / Kuesioner / Simulator
    └── Isi header ujian: nama, kelas, mapel, durasi (jam:menit)
    └── Tambah soal satu per satu (atau ambil dari Bank Soal)
    └── Opsional: buat instruksi ujian
    └── Opsional: merge dengan ujian lain
    └── Atur jadwal ujian (waktu mulai) per siswa
```

### D. Alur Pengerjaan Ujian Siswa

```
Siswa login
    └── Masuk menu Ujian → lihat daftar ujian aktif
    └── Klik ujian → baca instruksi (jika ada)
    └── Klik "Mulai Ujian" → sistem catat waktu mulai
    └── Kerjakan soal satu per satu
        ├── PG: pilih opsi jawaban
        ├── Essay: tulis jawaban teks
        ├── Visual: pilih/identifikasi gambar
        └── Kuesioner: pilih skala jawaban
    └── Timer countdown berjalan di halaman
    └── Klik "Selesai" atau timer habis → ujian otomatis dikumpulkan
    └── Sistem hitung nilai otomatis (PG, Visual, Kuesioner)
    └── Guru nilai manual (Essay)
```

---

## 12. Flow Transaksi Ujian

### Flow Detail: Ujian Pilihan Ganda (PG)

```
[1] Guru membuat Ujian
    INSERT INTO ujian (kode, nama, jenis=1, guru_id, kelas_id, mapel_id, jam, menit, acak)

[2] Guru menambah soal
    INSERT INTO detail_ujian (ujian_id, soal, opsi_a, opsi_b, opsi_c, opsi_d, kunci_jawaban, bobot)

[3] Guru menjadwalkan ujian untuk siswa
    INSERT INTO waktu_ujian (ujian_id, siswa_id, waktu_mulai, status=0)

[4] Siswa mulai ujian
    UPDATE waktu_ujian SET status=1, mulai_at=NOW() WHERE ujian_id=X AND siswa_id=Y

[5] Siswa menjawab tiap soal (real-time AJAX)
    INSERT/UPDATE pg_siswa (detail_ujian_id, kode, siswa_id, jawaban)

[6] Siswa selesai / waktu habis
    UPDATE waktu_ujian SET status=2, selesai_at=NOW() WHERE ...

[7] Sistem kalkulasi nilai otomatis
    nilai = Σ(bobot soal jika jawaban == kunci_jawaban) + nilai_tambahan
    UPDATE pg_siswa SET nilai = ... WHERE ...

[8] Guru melihat laporan
    SELECT * FROM pg_siswa JOIN detail_ujian JOIN siswa WHERE ujian.kode = ?
```

### Tipe Ujian dan Cara Penilaian

| Tipe | Kode Jenis | Penilaian |
|---|---|---|
| Pilihan Ganda (PG) | 1 | Otomatis: cocokkan jawaban dengan kunci |
| Essay | 2 | Manual: guru input nilai per jawaban |
| Visual | 3 | Otomatis: cocokkan dengan kunci visual |
| Kuesioner / Psikometri | 4 | Otomatis: kalkulasi skor per facet/skala |
| Simulator PG | 5 | Simulasi tanpa penilaian resmi |

### Kalkulasi Psikometri (Kuesioner)

```
Siswa menjawab kuesioner
    └── Setiap jawaban disimpan di kuesioner_siswas
    └── Setiap soal memiliki relasi ke facet (via detail_kuisoner_facets)
    └── Sistem menjumlah skor per facet
    └── Skor facet dikonversi ke T-Score menggunakan tabel t_scores
    └── T-Score diinterpretasikan menggunakan tabel interpretasis
    └── Hasil ditampilkan per domain (via tabel domains & domin_facets)
```

---

## 13. Struktur Frontend & Backend

### Backend (Laravel MVC)

```
Request masuk
    └── routes/web.php (atau api.php)
        └── Middleware (auth, role check)
            └── Controller method
                ├── Validasi input
                ├── Business logic
                ├── Model / Eloquent query
                └── Return view / redirect / JSON
```

**Konvensi Controller:**
- Satu controller per modul utama (bukan resource murni untuk semua).
- Method penamaan: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` + method khusus.
- Helper function di `app/helpers.php` untuk cek relasi guru-kelas/mapel.

### Frontend (Blade + Vite)

**Layout Utama:**
- `resources/views/template/main.blade.php` — digunakan oleh semua halaman non-ujian.
- `resources/views/template/mainUjian.blade.php` — layout khusus halaman pengerjaan ujian (minimalis, tanpa navigasi).

**Navbar per Role:**
- `template/navbar/admin.blade.php` — navigasi admin.
- `template/navbar/guru.blade.php` — navigasi guru.
- `template/navbar/siswa.blade.php` — navigasi siswa.

**Aset Frontend (Vite):**
- Entry point di `resources/js/app.js`.
- Build output ke `public/build/`.
- Hot reload tersedia dengan `npm run dev`.

**Rich Text Editor:**
- Summernote digunakan untuk pembuatan materi dan soal essay.
- Upload file dari Summernote ditangani oleh `SummernoteController`.
- File disimpan ke `storage/app/public/summernote/`.

**Komponen Blade:**
- `resources/views/components/ujian/jawaban-siswa-pilihan-ganda.blade.php` — komponen tampilan jawaban siswa PG yang dapat digunakan ulang.

---

## 14. Daftar API Endpoint

Sistem menggunakan API minimal (sebagian besar berbasis web session). Endpoint API yang tersedia:

| Method | URL | Fungsi | Auth |
|---|---|---|---|
| GET | `/api/siswa/ujian/IQCFIT` | Ambil data ujian IQCFIT (khusus psikometri) | Sanctum |
| POST | `/api/guru/merge_ujian/relasi_merge_ujian` | Simpan relasi merge ujian | Sanctum |

> **Catatan:** Sebagian besar interaksi AJAX (timer ujian, submit jawaban real-time) menggunakan route web dengan session cookie, bukan Bearer token.

---

## 15. Integrasi Layanan Eksternal

### Email (SMTP Gmail)
- **Library:** Laravel built-in Mail dengan driver SMTP.
- **Konfigurasi:** `config/mail.php` + variabel `.env` `MAIL_*`.
- **Provider:** Gmail SMTP (`smtp.googlemail.com:465`, SSL).
- **Template Email** (di `resources/views/emails/`):
  - `notif-akun.blade.php` — notifikasi pembuatan akun baru.
  - `verifikasi-akun.blade.php` — link aktivasi akun.
  - `notif-materi.blade.php` — notifikasi materi baru dipublish.
  - `notif-tugas.blade.php` — notifikasi tugas baru diberikan.
  - `notif-ujian.blade.php` — notifikasi ujian baru dijadwalkan.
  - `forgot-password.blade.php` — link reset password.

**Cara mengubah pengaturan SMTP:**
1. Ubah nilai `MAIL_*` di file `.env`, atau
2. Admin dapat mengubah konfigurasi melalui menu **Email Settings** di dashboard admin (disimpan di tabel `email_settings`).

### HTTP Client (Guzzle)
- Library Guzzle 7.2 tersedia untuk integrasi API eksternal masa depan.
- Saat ini belum ada integrasi aktif ke layanan pihak ketiga berbayar (Xendit, OTP, dsb).

### PDF Generation (DomPDF)
- **Library:** `barryvdh/laravel-dompdf` v3.1.
- Digunakan untuk cetak: soal ujian, nilai tugas, laporan T-Score.
- Template PDF di `resources/views/pdf/` dan `resources/views/ekspor/`.

### Excel Import/Export (Maatwebsite)
- **Library:** `maatwebsite/excel` v3.1.
- **Import:** Upload file Excel untuk registrasi massal siswa/guru.
- **Export:** Download daftar siswa, guru, dan nilai ujian ke format Excel.
- Class Export di `app/Exports/`, class Import di `app/Imports/`.

---

## 16. Seeder, Migration & Data Dummy

### Menjalankan Migration

```bash
# Jalankan semua migration
php artisan migrate

# Rollback semua migration
php artisan migrate:rollback

# Reset dan jalankan ulang semua migration
php artisan migrate:fresh

# Migration + seed sekaligus
php artisan migrate:fresh --seed
```

### Seeder yang Tersedia (38 Seeder)

| Seeder | Fungsi |
|---|---|
| `DatabaseSeeder` | Orchestrator utama, memanggil semua seeder |
| `GuruSeeder` | Data guru sample |
| `SiswaSeeder` | Data siswa sample |
| `KelasSeeder` | Data kelas |
| `MapelSeeder` | Data mata pelajaran |
| `GuruKelasSeeder` | Relasi guru ↔ kelas |
| `GuruMapelSeeder` | Relasi guru ↔ mapel |
| `FacetSeeder` | Data facet psikologi (kode & deskripsi) |
| `MmpiSeeder` | Data soal dan konfigurasi MMPI |
| `InterpretasiSeeder` | Panduan interpretasi hasil asesmen |
| `DomainSeeder` | Domain asesmen psikologi |
| `SekalaSeeder` | Data skala penilaian kuesioner |
| `JenisJawabanKuesionerSeeder` | Tipe jawaban kuesioner |
| `DetailJawabanKuisoner` | Pilihan jawaban kuesioner |
| `KuesionerSeeder` | Data soal kuesioner |
| `Part1_1Seeder` s/d `Part5_3Seeder` | Bank soal MMPI per bagian |
| `UpdatePart2Seeder` | Update data bank soal MMPI bagian 2 |
| `UpdatePart5_2Seeder` | Update data bank soal MMPI bagian 5.2 |
| `WaktuUjianSeeder` | Data jadwal ujian sample |
| `UpdateWaktuUjian` | Update data jadwal ujian |
| `PilihanGandaSeeder` | Data soal pilihan ganda sample |
| `MargeUjianSeeder` | Data merge ujian sample |
| `KlasifikasiIqSeeder` | Tabel klasifikasi skor IQ |
| `TScoreSeeder` | Data norma T-Score |
| `SkorKalender` | Data kalender skor |
| `EmailSettingsSeeder` | Konfigurasi SMTP default |
| `PerbaikanKodeSekalaSeeder` | Fix kode skala yang salah |
| `setPerbaikanCodeSekalaSeeder` | Fix lanjutan kode skala |

### Menjalankan Seeder Spesifik

```bash
# Jalankan satu seeder tertentu
php artisan db:seed --class=FacetSeeder

# Jalankan seeder utama (semua)
php artisan db:seed
```

> **Penting:** Seeder MMPI (`Part1_1Seeder` hingga `Part5_3Seeder`) berisi data soal psikometri yang harus dijalankan berurutan. Gunakan `DatabaseSeeder` untuk memastikan urutan yang benar.

---

## 17. Laporan yang Tersedia dalam Sistem

### Laporan untuk Guru
| Laporan | URL | Format | Fungsi |
|---|---|---|---|
| Hasil Ujian PG per Siswa | `/guru/ujian/{kode}/show-siswa` | Web | Lihat jawaban & nilai PG tiap siswa |
| Cetak Soal PG | `/guru/ujian/{kode}/cetak-pg` | PDF | Cetak lembar soal PG |
| Hasil Ujian Essay | `/guru/ujian/{kode}/essay/siswa` | Web | Lihat & nilai jawaban essay |
| Cetak Soal Essay | `/guru/ujian/{kode}/cetak-essay` | PDF | Cetak lembar soal Essay |
| Hasil Kuesioner Siswa | `/guru/ujian/{kode}/kuesioner/siswa` | Web | Lihat hasil kuesioner tiap siswa |
| Rekap Nilai Tugas | `/guru/tugas/{kode}/cetak` | PDF | Cetak rekap nilai tugas per kelas |
| Laporan Ujian Siswa | `/guru/laporan/ujian-siswa` | Web | Laporan komprehensif hasil ujian |

### Laporan untuk Siswa
| Laporan | URL | Format | Fungsi |
|---|---|---|---|
| Hasil Ujian PG | `/siswa/hasil-ujian/{kode}/pg` | Web | Rincian jawaban & nilai PG |
| Hasil Ujian Essay | `/siswa/hasil-ujian/{kode}/essay` | Web | Rincian jawaban & nilai Essay |
| Hasil Ujian Visual | `/siswa/hasil-ujian/{kode}/visual` | Web | Rincian jawaban & nilai Visual |
| Hasil Kuesioner | `/siswa/hasil-ujian/{kode}/kuesioner` | Web | Rincian skor kuesioner per facet |
| T-Score | `/tscore/{siswa_id}` | Web | Profil T-Score psikometri siswa |
| Cetak T-Score | `/tscore/{siswa_id}/print` | PDF | Cetak laporan T-Score |

### Export Data (Admin & Guru)
| Export | URL | Format |
|---|---|---|
| Daftar Siswa | `/admin/siswa/export` | Excel (.xlsx) |
| Daftar Guru | `/admin/guru/export` | Excel (.xlsx) |
| Nilai Ujian PG | via `LaporanController` | Excel (.xlsx) |
| Nilai Ujian Essay | via `LaporanController` | Excel (.xlsx) |

---

## 18. Jobs, Queue, Scheduler & Event

### Queue
- **Driver default:** `sync` (eksekusi langsung, tanpa queue worker).
- Tabel `jobs` dan `failed_jobs` tersedia untuk migrasi ke driver async (database/redis).
- Untuk menggunakan queue database:
  ```bash
  # Ubah di .env
  QUEUE_CONNECTION=database

  # Jalankan worker
  php artisan queue:work
  ```

### Email Job
- Pengiriman email (aktivasi, notifikasi, reset password) dilakukan melalui `Mail::send()` atau `Mail::queue()`.
- Jika `QUEUE_CONNECTION=sync`, email dikirim langsung saat request.
- Jika `QUEUE_CONNECTION=database`, email masuk antrian dan diproses oleh worker.

### Scheduler
- File: `app/Console/Kernel.php`
- Saat ini belum ada scheduled task yang terdefinisi secara aktif.
- Untuk mengaktifkan scheduler di production, tambahkan cron job:
  ```bash
  * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
  ```

### Events & Listeners
- Saat ini sistem belum menggunakan Laravel Event/Listener secara eksplisit.
- Logika notifikasi dan email dieksekusi langsung di controller.

---

## 19. Konvensi Penulisan Kode

### Umum
- **Bahasa:** Indonesia untuk nama variabel domain (nama_siswa, kelas_id), English untuk nama method dan teknis.
- **Indentasi:** 4 spasi (sesuai standar Laravel/PSR-2).
- **Nama file:** PascalCase untuk class (Model, Controller), snake_case untuk view dan migration.

### Model (Eloquent)
```php
// Gunakan $fillable (bukan $guarded) untuk keamanan mass assignment
protected $fillable = ['nama', 'email', 'kelas_id'];

// Gunakan route key yang readable (bukan id numerik)
public function getRouteKeyName()
{
    return 'kode'; // untuk Ujian, Tugas, Materi, BankSoal
}

// Definisikan relasi dengan nama yang deskriptif
public function detailUjian()
{
    return $this->hasMany(DetailUjian::class, 'ujian_id');
}
```

### Controller
```php
// Validasi input di awal method
$request->validate([
    'nama' => 'required|string|max:255',
    'kelas_id' => 'required|exists:kelas,id',
]);

// Gunakan eager loading untuk mencegah N+1 query
$ujian = Ujian::with(['detailUjian', 'guru', 'kelas', 'mapel'])->findOrFail($kode);
```

### Routes
```php
// Gunakan middleware grup untuk proteksi role
Route::middleware(['auth', 'is_guru'])->prefix('guru')->group(function () {
    // route guru
});
```

### Blade Template
- Gunakan `@section` dan `@yield` untuk template inheritance.
- Gunakan `@include` untuk komponen kecil yang berulang.
- Selalu gunakan `{{ }}` (bukan `{!! !!}`) kecuali untuk konten HTML yang sudah disanitasi.
- `{!! $materi->teks !!}` digunakan untuk konten Summernote (HTML rich-text).

### Helper Function
Helper tersedia di `app/helpers.php` (di-autoload via composer):
```php
// Cek apakah guru mengajar di kelas tertentu
check_kelas($id_guru, $id_kelas): bool

// Cek apakah guru mengajar mata pelajaran tertentu
check_mapel($id_guru, $id_mapel): bool
```

---

## 20. Panduan Deployment

### Deployment ke Shared Hosting / VPS

**1. Upload file project**
```bash
git clone <repo> /var/www/html/talenta-muda
```

**2. Konfigurasi web server**

Contoh Virtual Host Apache:
```apache
<VirtualHost *:80>
    ServerName talentamuda.example.com
    DocumentRoot /var/www/html/talenta-muda/public

    <Directory /var/www/html/talenta-muda/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Contoh konfigurasi Nginx:
```nginx
server {
    listen 80;
    server_name talentamuda.example.com;
    root /var/www/html/talenta-muda/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

**3. Install dependensi production**
```bash
composer install --no-dev --optimize-autoloader
npm run build
```

**4. Konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
# Edit .env untuk production
```

**5. Permission folder**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**6. Jalankan migration dan seeder**
```bash
php artisan migrate --force
php artisan db:seed --force
```

**7. Buat symlink storage**
```bash
php artisan storage:link
```

**8. Optimasi untuk production**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

**9. Setup cron (opsional)**
```bash
crontab -e
# Tambahkan:
* * * * * cd /var/www/html/talenta-muda && php artisan schedule:run >> /dev/null 2>&1
```

### Deployment di XAMPP (Local/Hosting Internal)

```
1. Letakkan folder project di: C:\xampp\htdocs\talenta-muda\
2. Konfigurasi APP_URL=http://localhost/talenta-muda di .env
3. Akses via browser: http://localhost/talenta-muda/public
   Atau konfigurasikan Virtual Host XAMPP untuk akses tanpa subfolder /public
```

---

## 21. Daftar Fitur Selesai & Dalam Pengembangan

### Fitur Selesai ✅

#### Manajemen Sistem
- [x] Login, logout, dan reset password semua role
- [x] Aktivasi akun via email token
- [x] Manajemen admin (profil & password)
- [x] Wizard instalasi awal (`/install`)
- [x] Konfigurasi SMTP dari dashboard admin

#### Manajemen Akademik
- [x] CRUD kelas dengan toggle status aktif
- [x] CRUD mata pelajaran
- [x] CRUD guru dengan import/export Excel
- [x] CRUD siswa dengan import/export Excel
- [x] Relasi guru ↔ kelas (many-to-many)
- [x] Relasi guru ↔ mapel (many-to-many)

#### Pembelajaran
- [x] Materi pembelajaran dengan Summernote rich-text editor
- [x] Upload file/gambar pada materi via Summernote
- [x] Tugas dengan tenggat waktu
- [x] Pengumpulan tugas oleh siswa
- [x] Penilaian tugas oleh guru
- [x] Cetak rekap nilai tugas (PDF)

#### Sistem Ujian
- [x] Ujian Pilihan Ganda dengan kunci jawaban otomatis
- [x] Ujian Essay dengan penilaian manual guru
- [x] Ujian Visual
- [x] Ujian Kuesioner / Psikometri
- [x] Simulator Ujian PG
- [x] Simulator Ujian Visual
- [x] Simulator Ujian Essay
- [x] Bank Soal PG dan Essay
- [x] Merge/gabung beberapa ujian
- [x] Instruksi ujian (slide view)
- [x] Timer countdown ujian
- [x] Pengacakan soal (fitur `acak`)
- [x] Jadwal ujian per siswa (`waktu_ujian`)
- [x] Nilai tambahan untuk ujian PG

#### Psikometri & Asesmen
- [x] Kuesioner berbasis facet psikologi
- [x] Integrasi MMPI (Minnesota Multiphasic Personality Inventory)
- [x] Kalkulasi T-Score berdasarkan norma
- [x] Klasifikasi IQ
- [x] Interpretasi hasil asesmen otomatis
- [x] Laporan T-Score (Web & PDF)
- [x] Kalender skor

#### Laporan & Export
- [x] Laporan hasil ujian PG per siswa
- [x] Laporan hasil essay per siswa
- [x] Laporan kuesioner per siswa
- [x] Cetak soal PG dan Essay (PDF)
- [x] Export nilai ke Excel
- [x] Export/import data siswa & guru

#### Komunikasi
- [x] Notifikasi email untuk akun baru, materi, tugas, ujian
- [x] Chat dalam sistem (userchat)
- [x] Notifikasi in-app

### Fitur Dalam Pengembangan / Belum Selesai 🚧

- [ ] Integrasi pembayaran (Xendit atau gateway lain)
- [ ] Verifikasi OTP via SMS/WhatsApp
- [ ] Face Recognition untuk autentikasi ujian
- [ ] Scheduled task otomatis (tutup ujian otomatis saat deadline)
- [ ] Dashboard analytics yang lebih lengkap (grafik, statistik tren)
- [ ] Notifikasi push browser (WebSocket/Pusher)
- [ ] Mode ujian offline / progressive web app
- [ ] Multi-bahasa (i18n) selain Bahasa Indonesia
- [ ] API lengkap dengan dokumentasi Swagger/Postman
- [ ] Unit test coverage untuk controller dan model

---

## 22. Troubleshooting & Solusi Umum

### Error: `Class "App\Http\Middleware\IsAdmin" not found`
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: `SQLSTATE[HY000] [1045] Access denied for user 'root'`
Periksa konfigurasi `DB_USERNAME`, `DB_PASSWORD` di `.env`. Pastikan user MySQL memiliki akses ke database `talenta_muda`.

### Halaman Tampil Kosong / Error 500 Tanpa Pesan
```bash
# Aktifkan debug mode sementara
# Di .env: APP_DEBUG=true

# Cek log aplikasi
tail -f storage/logs/laravel.log
```

### File yang Diupload Tidak Tampil
```bash
# Pastikan symlink storage sudah dibuat
php artisan storage:link

# Pastikan permission folder
chmod -R 775 storage/
```

### Email Tidak Terkirim
1. Pastikan konfigurasi `MAIL_*` di `.env` benar.
2. Gunakan **App Password** Gmail (bukan password akun biasa) — aktifkan 2FA Gmail terlebih dahulu.
3. Periksa `storage/logs/laravel.log` untuk pesan error SMTP.
4. Coba kirim email test:
   ```bash
   php artisan tinker
   Mail::raw('Test email', fn($m) => $m->to('test@example.com')->subject('Test'));
   ```

### Error: `The Mix manifest does not exist`
Project menggunakan Vite, bukan Mix. Jalankan:
```bash
npm install
npm run build   # production
npm run dev     # development
```

### Ujian Tidak Bisa Dimulai Siswa
1. Pastikan ada record di tabel `waktu_ujian` untuk siswa tersebut.
2. Pastikan status `waktu_ujian.status = 0` (belum mulai).
3. Pastikan kelas siswa sesuai dengan kelas di ujian.
4. Periksa apakah guru sudah assign ujian ke kelas siswa.

### Migration Error: `Table already exists`
```bash
# Reset database (HATI-HATI: menghapus semua data)
php artisan migrate:fresh --seed
```

### Nilai T-Score Tidak Muncul
Data norma di tabel `t_scores` atau `skor_kalenders` belum ada.
```bash
php artisan db:seed --class=TScoreSeeder
php artisan db:seed --class=SkorKalender
```

---

## 23. Catatan Teknis & Best Practice

### Keamanan
- **CSRF Protection:** Semua form POST menggunakan `@csrf` token (Laravel default). Jangan menonaktifkan middleware `VerifyCsrfToken` kecuali untuk route API.
- **SQL Injection:** Gunakan Eloquent ORM atau `DB::select()` dengan parameter binding. Jangan interpolasi input langsung ke query.
- **XSS:** Gunakan `{{ }}` di Blade untuk escaping. Gunakan `{!! !!}` hanya untuk konten HTML dari Summernote yang sudah divalidasi.
- **Mass Assignment:** Selalu definisikan `$fillable` pada model, bukan `$guarded = []`.
- **Password:** Gunakan `Hash::make()` untuk menyimpan password. Jangan simpan plaintext.
- **File Upload:** Validasi tipe dan ukuran file. Simpan di `storage/app/public/`, bukan di folder `public/` langsung.

### Performa
- **Eager Loading:** Selalu gunakan `with()` untuk relasi yang pasti dibutuhkan, hindari query N+1.
  ```php
  // Buruk
  $ujian = Ujian::find($id);
  $ujian->guru->nama; // query tambahan

  // Baik
  $ujian = Ujian::with('guru')->find($id);
  ```
- **Pagination:** Gunakan `->paginate(15)` untuk daftar data yang besar, bukan `->get()`.
- **Cache:** Pertimbangkan cache untuk data yang jarang berubah (master data facet, interpretasi MMPI).
- **Index Database:** Pastikan kolom yang sering digunakan sebagai `WHERE` atau `JOIN` sudah memiliki index (foreign key sudah otomatis ter-index di MySQL).

### Pengembangan Lanjutan
- **Konsistensi Tipe Ujian:** Field `jenis` di tabel `ujian` menggunakan integer. Buat konstanta di model `Ujian` untuk kejelasan:
  ```php
  const JENIS_PG         = 1;
  const JENIS_ESSAY      = 2;
  const JENIS_VISUAL     = 3;
  const JENIS_KUESIONER  = 4;
  const JENIS_SIMULATOR  = 5;
  ```
- **Typo pada Nama:** Terdapat inkonsistensi penamaan — `domin_facets` vs `domain_facets`, `intruksi` vs `instruksi`. Perbaiki secara bertahap via migration baru, jangan ubah nama tabel yang sudah production.
- **Route Key:** Model yang menggunakan `kode` sebagai route key (`Ujian`, `Tugas`, `Materi`, `BankSoal`) — pastikan field `kode` bersifat unik dan tidak dapat diubah setelah dibuat untuk menghindari broken link.
- **Konfigurasi Email dari DB:** Sistem memiliki tabel `email_settings` untuk menyimpan konfigurasi SMTP di database. Pastikan konfigurasi ini di-load saat bootstrap jika ingin override nilai dari `.env`.
- **Testing:** Tambahkan feature test untuk alur kritis: login tiap role, submit ujian, kalkulasi nilai.
  ```bash
  php artisan test
  ```
- **Backup:** Buat jadwal backup otomatis database `talenta_muda` dan folder `storage/app/public/` secara berkala.
- **Logging:** Pantau `storage/logs/laravel.log`. Pertimbangkan integrasi dengan layanan logging terpusat (Sentry, Papertrail) untuk production.

---

*Dokumentasi ini dibuat berdasarkan analisis source code proyek Talenta Muda Laravel. Perbarui dokumen ini setiap kali ada perubahan signifikan pada arsitektur, modul baru, atau perubahan database schema.*

**Tim Developer Talenta Muda** | Kontak: team3.claude@treemas.co.id
