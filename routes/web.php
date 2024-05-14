<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermission\RoleController;
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
    // Route::get('mbkm/admin/role-permissions/permission', [\App\Http\Controllers\RolePermission\PermissionController::class, 'index'])->name('permission.index');
    Route::post('mbkm/admin/role-permissions/permission/json', [\App\Http\Controllers\RolePermission\PermissionController::class, 'json'])->name('permission.json');



    // Route::resource('mbkm/admin/role-permissions/role', \App\Http\Controllers\RolePermission\RoleController::class);
    // Route::post('mbkm/admin/role-permissions/role/json', [\App\Http\Controllers\RolePermission\RoleController::class, 'json'])->name('role.json');
    // Route::get('mbkm/admin/role-permissions/{roleId}/add-Permission', [\App\Http\Controllers\RolePermission\RoleController::class, 'addPermissionToRole'])->name('role.addPermission');

    Route::post('mbkm/admin/role-permissions/role/json', [RoleController::class, 'json'])->name('role.json');
    Route::get('mbkm/admin/role-permissions/', [RoleController::class, 'index'])->name('role.index');
    Route::get('mbkm/admin/role-permissions/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('mbkm/admin/role-permissions/', [RoleController::class, 'store'])->name('role.store');
    Route::get('mbkm/admin/role-permissions/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('mbkm/admin/role-permissions/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('mbkm/admin/role-permissions/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::get('mbkm/admin/role-permissions/{roleId}/add-permission', [RoleController::class, 'addPermissionToRole'])->name('role.addPermission');

});

require __DIR__ . '/auth.php';
