<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrasiController;



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

    // Route::resource('mbkm/staff/peserta', \App\Http\Controllers\PesertaController::class);
    Route::get('mbkm/staff/peserta', [\App\Http\Controllers\PesertaController::class, 'index'])->name('peserta.index');
    Route::get('mbkm/staff/peserta/create', [\App\Http\Controllers\PesertaController::class, 'create'])->name('peserta.create');
    Route::post('mbkm/staff/peserta', [\App\Http\Controllers\PesertaController::class, 'store'])->name('peserta.store');
    Route::get('mbkm/staff/peserta/{peserta}', [\App\Http\Controllers\PesertaController::class, 'show'])->name('peserta.show');
    Route::get('mbkm/staff/peserta/{peserta}/edit', [\App\Http\Controllers\PesertaController::class, 'edit'])->name('peserta.edit');
    Route::put('mbkm/staff/peserta/{peserta}', [\App\Http\Controllers\PesertaController::class, 'update'])->name('peserta.update');
    Route::delete('mbkm/staff/peserta/{peserta}', [\App\Http\Controllers\PesertaController::class, 'destroy'])->name('peserta.destroy');
    Route::post('mbkm/staff/peserta/json', [\App\Http\Controllers\PesertaController::class, 'json'])->name('peserta.json');


    // Route::get('/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'index'])->name('registrasi.index');
    // Route::get('/peserta-registrasi', [\App\Http\Controllers\RegistrasiController::class, 'showPesertaRegistrasiForm'])->name('peserta.registrasiForm');
    // Route::post('/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'store'])->name('registrasi.store');
    // Route::put('/registrasi/{id}', [\App\Http\Controllers\RegistrasiController::class, 'update'])->name('registrasi.update');
    // Route::post('/registrasi/{id}/accept', [\App\Http\Controllers\RegistrasiController::class, 'acceptOffer'])->name('registrasi.acceptOffer');
    // Route::get('/peserta/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'showPesertaRegistrasiForm'])->name('peserta.registrasiForm');

    // Route::get('/peserta/registrasi', [RegistrasiController::class, 'showPesertaRegistrasiForm'])->name('peserta.registrasiForm');
    // Route::post('/peserta/registrasi', [RegistrasiController::class, 'store'])->name('peserta.registrasi');
    // Route::get('/registrasi/{id}/registrations-and-accept-offer', [RegistrasiController::class, 'showRegistrationsAndAcceptOffer'])->name('registrasi.registrations-and-accept-offer');
    // Route::get('/staff/registrasi', [RegistrasiController::class, 'index'])->name('staff.registrasiIndex');
    // Route::put('/staff/registrasi/{id}', [RegistrasiController::class, 'update'])->name('staff.updateRegistrasi');
    // Route::post('/peserta/registrasi/{id}/accept', [RegistrasiController::class, 'acceptOffer'])->name('peserta.acceptOffer');

    Route::get('/peserta/registrasi', [RegistrasiController::class, 'showPesertaRegistrasiForm'])->name('peserta.registrasiForm');
    Route::post('/peserta/registrasi', [RegistrasiController::class, 'store'])->name('peserta.registrasi');
    Route::post('/peserta/registrasi/{id}/accept', [RegistrasiController::class, 'acceptOffer'])->name('peserta.acceptOffer');
    Route::get('/registrasi/{id}/registrations-and-accept-offer', [RegistrasiController::class, 'showRegistrationsAndAcceptOffer'])->name('registrasi.registrations-and-accept-offer');
    Route::get('/staff/registrasi', [RegistrasiController::class, 'index'])->name('staff.registrasiIndex');
    Route::put('/staff/registrasi/{id}', [RegistrasiController::class, 'update'])->name('staff.updateRegistrasi');
    

});
require __DIR__ . '/auth.php';


Route::resource('mahasiswa', \App\Http\Controllers\sisfo\MahasiswaController::class);
Route::resource('dosen', \App\Http\Controllers\sisfo\DosenController::class);
