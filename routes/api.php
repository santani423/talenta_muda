<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UjianSiswaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes in this file are automatically assigned the "api" middleware group.
| You can register your API endpoints here.
|
*/

// Contoh: Route untuk mendapatkan user jika menggunakan Sanctum (bisa diaktifkan jika dibutuhkan)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Endpoint: Cek Waktu Ujian untuk Siswa
Route::post('/siswa/cek-waktu-ujian', [UjianSiswaController::class, 'cek_waktu_ujian'])->name('siswa.cek_waktu_ujian');
