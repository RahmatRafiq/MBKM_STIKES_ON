<?php

use App\Http\Controllers\DosenPembimbingLapanganController;
use App\Http\Controllers\MitraProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dosen-pembimbing-lapangan', [DosenPembimbingLapanganController::class, 'index']);
Route::get('/mitra-profile', [MitraProfileController::class, 'index']);