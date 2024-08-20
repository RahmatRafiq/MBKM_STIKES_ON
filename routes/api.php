<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api')->group(function () {
    Route::post('/login', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    })->name('login');
});

// Rute baru tanpa autentikasi
Route::get('/laporan-lengkap-peserta/json', [ApiController::class, 'getValidatedLaporanLengkap']);

// Route fallback untuk menangani rute yang tidak ditemukan
Route::fallback(function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Endpoint not found'
    ], 404);
});
