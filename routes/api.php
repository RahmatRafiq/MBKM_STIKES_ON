<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api')->group(function () {
    Route::post('/login', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    })->name('login');
});

Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::get('/laporan-lengkap-peserta/json', [ApiController::class, 'getValidatedLaporanLengkap']);
    Route::get('/dosen-sisfo/json', [ApiController::class, 'getDataDosenSisfo']);
});
Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Endpoint not found',
    ], 404);
});
