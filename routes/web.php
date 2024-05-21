<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('applications/mbkm/dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::get('mbkm/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('mbkm/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('mbkm/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('mbkm/admin/role-permissions/permission', \App\Http\Controllers\RolePermission\PermissionController::class);
    Route::post('mbkm/admin/role-permissions/permission/json', [\App\Http\Controllers\RolePermission\PermissionController::class, 'json'])->name('permission.json');

    Route::resource('mbkm/admin/role-permissions/role', \App\Http\Controllers\RolePermission\RoleController::class);
    Route::post('mbkm/admin/role-permissions/role/json', [\App\Http\Controllers\RolePermission\RoleController::class, 'json'])->name('role.json');

    Route::resource('mbkm/admin/role-permissions/user', UserController::class);
    Route::post('mbkm/admin/role-permissions/user/json', [UserController::class, 'json'])->name('user.json');

    Route::resource('mbkm/staff/mitra', \App\Http\Controllers\MitraProfileController::class);
    Route::post('mbkm/staff/mitra/json', [\App\Http\Controllers\MitraProfileController::class, 'json'])->name('mitra.json');
    Route::post('mbkm/staff/mitra/create', [\App\Http\Controllers\MitraProfileController::class, 'storeMitraUser'])->name('mitra.user.store');

    Route::resource('mbkm/mitra/lowongan', \App\Http\Controllers\LowonganController::class);

    Route::post('/temp/storage', [\App\Http\Controllers\StorageController::class, 'store'])->name('storage.store');
    Route::delete('/temp/storage', [\App\Http\Controllers\StorageController::class, 'destroy'])->name('storage.destroy');
    Route::get('/temp/storage/{path}', [\App\Http\Controllers\StorageController::class, 'show'])->name('storage.show');

    Route::resource('mbkm/staff/dospem', \App\Http\Controllers\DosenPembimbingLapanganController::class);
    Route::post('mbkm/staff/dospem/json', [\App\Http\Controllers\DosenPembimbingLapanganController::class, 'json'])->name('dospem.json');
});
require __DIR__ . '/auth.php';


Route::resource('mahasiswa', \App\Http\Controllers\sisfo\MahasiswaController::class);
Route::resource('dosen', \App\Http\Controllers\sisfo\DosenController::class);
