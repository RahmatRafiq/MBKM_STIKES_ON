<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiLowonganController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.optional'])->group(function () {
    Route::get('/lowongan', [ApiLowonganController::class, 'getLowongan'])->name('api.lowongan.index');

    Route::get('/lowongan/{id}', [ApiLowonganController::class, 'getLowonganDetail'])->name('api.lowongan.detail');

    Route::post('/lowongan/register', [ApiLowonganController::class, 'registerForLowongan'])->name('api.lowongan.register');
});

Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::get('/laporan-lengkap-peserta/json', [ApiController::class, 'getValidatedLaporanLengkap']);
    Route::get('/dosen-sisfo/json', [ApiController::class, 'getDataDosenSisfo']);
    Route::get('/mahasiswa-sisfo/json', [ApiController::class, 'getDataMahasiswaSisfo']);
    Route::get('/matakuliah-sisfo/json', [ApiController::class, 'getDataMataKuliahSisfo']);
});

Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Endpoint tidak ditemukan',
    ], 404);
});
