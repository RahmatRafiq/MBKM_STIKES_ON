<?php

use App\Http\Controllers\DosenPembimbingLapanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dosen-pembimbing-lapangan', [DosenPembimbingLapanganController::class, 'index']);
