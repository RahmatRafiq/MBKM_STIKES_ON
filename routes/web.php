<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermission\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('applications/mbkm/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('mbkm/admin/role-permissions/permission', \App\Http\Controllers\RolePermission\PermissionController::class);
    Route::get('mbkm/admin/role-permissions/permission', [\App\Http\Controllers\RolePermission\PermissionController::class, 'index'])->name('permission.index');
    Route::post('mbkm/admin/role-permissions/permission/json', [\App\Http\Controllers\RolePermission\PermissionController::class, 'json'])->name('permission.json');
    Route::get('mbkm/admin/role-permissions/permission/create', [\App\Http\Controllers\RolePermission\PermissionController::class, 'create'])->name('permission.create');
    // Route::delete('mbkm/admin/role-permissions/permission/{permission}', [\App\Http\Controllers\RolePermission\PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::resource('mbkm/admin/role-permissions/role', \App\Http\Controllers\RolePermission\RoleController::class);
    Route::get('mbkm/admin/role-permissions/role', [\App\Http\Controllers\RolePermission\RoleController::class, 'index'])->name('role.index');
    Route::post('mbkm/admin/role-permissions/role/json', [\App\Http\Controllers\RolePermission\RoleController::class, 'json'])->name('role.json');
    Route::get('mbkm/admin/role-permissions/role/create', [\App\Http\Controllers\RolePermission\RoleController::class, 'create'])->name('role.create');
    Route::put('mbkm/admin/role-permissions/role/{role}', [\App\Http\Controllers\RolePermission\RoleController::class, 'update'])->name('role.update');
    Route::delete('mbkm/admin/role-permissions/role/{role}', [\App\Http\Controllers\RolePermission\RoleController::class, 'destroy'])->name('role.destroy');
});

require __DIR__ . '/auth.php';
