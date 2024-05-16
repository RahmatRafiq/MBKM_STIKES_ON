<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('applications/mbkm/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
});
require __DIR__ . '/auth.php';
