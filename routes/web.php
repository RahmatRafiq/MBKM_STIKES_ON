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



    Route::resource('mbkm/admin/role-permissions/role', \App\Http\Controllers\RolePermission\RoleController::class);
    Route::post('mbkm/admin/role-permissions/role/json', [\App\Http\Controllers\RolePermission\RoleController::class, 'json'])->name('role.json');
    Route::get('mbkm/admin/role-permissions/p/{roleId}/add-Permission', [\App\Http\Controllers\RolePermission\RoleController::class, 'addPermissionToRole'])->name('role.addPermission');

});

require __DIR__ . '/auth.php';
