<?php

use App\Http\Controllers\LaporanApiController;
use App\Http\Controllers\MergeUjianController;
use App\Http\Controllers\UjianSiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/siswa/ujian/IQCFIT', [UjianSiswaController::class, 'IQCFIT']);
Route::post('/guru/merge_ujian/relasi_merge_ujian', [MergeUjianController::class, 'relasi_merge_ujian']);

// Laporan API
Route::get('/laporan/siswa', [LaporanApiController::class, 'siswa']);
Route::get('/laporan/batch', [LaporanApiController::class, 'batch']);
Route::get('/laporan/siswa/{id}/semua-nilai', [LaporanApiController::class, 'semuaNilai']);
