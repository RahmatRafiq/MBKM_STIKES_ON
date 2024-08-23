<?php

use App\Http\Middleware\ApiKeyMiddleware;
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
// Rute baru yang dilindungi oleh middleware API key
Route::middleware([ApiKeyMiddleware::class])->get('/laporan-lengkap-peserta/json', [ApiController::class, 'getValidatedLaporanLengkap']);
Route::get('/mahasiswa-sisfo/json', [ApiController::class, 'getDataMahasiswaSisfo']);
Route::fallback(function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Endpoint not found'
    ], 404);
});
