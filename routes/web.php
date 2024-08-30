<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('mbkm/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('mbkm/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('mbkm/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:super admin'])->group(function () {
        Route::get('mbkm/manajemen-aplikasi/about-mbkm', [\App\Http\Controllers\AboutMbkmController::class, 'index'])->name('about-mbkms.index');
        Route::post('mbkm/manajemen-aplikasi/about-mbkm', [\App\Http\Controllers\AboutMbkmController::class, 'update'])->name('about-mbkms.update');

        Route::resource('mbkm/manajemen-aplikasi/batch-mbkms', \App\Http\Controllers\BatchMbkmController::class);
        Route::post('mbkm/manajemen-aplikasi/batch-mbkms/json', [\App\Http\Controllers\BatchMbkmController::class, 'json'])->name('batch-mbkms.json');

        Route::resource('mbkm/manajemen-aplikasi/type-programs', \App\Http\Controllers\TypeProgramController::class);
        Route::post('mbkm/manajemen-aplikasi/type-programs/json', [\App\Http\Controllers\TypeProgramController::class, 'json'])->name('type-programs.json');

        Route::resource('mbkm/admin/role-permissions/permission', \App\Http\Controllers\RolePermission\PermissionController::class);
        Route::post('mbkm/admin/role-permissions/permission/json', [\App\Http\Controllers\RolePermission\PermissionController::class, 'json'])->name('permission.json');

        Route::resource('mbkm/admin/role-permissions/role', \App\Http\Controllers\RolePermission\RoleController::class);
        Route::post('mbkm/admin/role-permissions/role/json', [\App\Http\Controllers\RolePermission\RoleController::class, 'json'])->name('role.json');

        Route::resource('mbkm/admin/role-permissions/user', \App\Http\Controllers\UserController::class);
        Route::post('mbkm/admin/role-permissions/user/json', [\App\Http\Controllers\UserController::class, 'json'])->name('user.json');
    });

    Route::middleware(['role:peserta|super admin'])->group(function () {
        Route::get('/registrasi/filter', [\App\Http\Controllers\RegistrasiController::class, 'filter'])->name('peserta.filter');
        Route::get('/peserta/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'showPesertaRegistrasiForm'])->name('peserta.registrasiForm');
        Route::post('/peserta/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'store'])->name('peserta.registrasi');
        Route::post('/peserta/registrasi/{id}/accept', [\App\Http\Controllers\RegistrasiController::class, 'acceptOffer'])->name('peserta.acceptOffer');
        Route::post('/peserta/registrasi/{id}/reject', [\App\Http\Controllers\RegistrasiController::class, 'rejectOffer'])->name('peserta.rejectOffer');
        Route::get('/registrasi/{id}/registrations-and-accept-offer', [\App\Http\Controllers\RegistrasiController::class, 'showRegistrationsAndAcceptOffer'])->name('registrasi.registrations-and-accept-offer');

        Route::get('/laporan-harian', [\App\Http\Controllers\AktivitasMbkmController::class, 'createLaporanHarian'])->name('laporan.harian');
        Route::get('/laporan-harian/create', [\App\Http\Controllers\AktivitasMbkmController::class, 'createLaporanHarian'])->name('laporan.harian.create');
        Route::post('/laporan-harian/store', [\App\Http\Controllers\AktivitasMbkmController::class, 'storeLaporanHarian'])->name('laporan.harian.store');
        Route::post('/laporan-harian/upload-dokumen', [\App\Http\Controllers\AktivitasMbkmController::class, 'uploadLaporanHarian'])->name('laporan.harian.uploadDokumen');
        Route::delete('/laporan-harian/delete-dokumen', [\App\Http\Controllers\AktivitasMbkmController::class, 'deleteDokumen'])->name('laporan.harian.deleteDokumen');

        Route::get('/laporan-mingguan/create', [\App\Http\Controllers\AktivitasMbkmController::class, 'createLaporanMingguan'])->name('laporan.mingguan.create');
        Route::post('/laporan-mingguan/store', [\App\Http\Controllers\AktivitasMbkmController::class, 'storeLaporanMingguan'])->name('laporan.mingguan.store');

        Route::get('/laporan-lengkap/create', [\App\Http\Controllers\AktivitasMbkmController::class, 'createLaporanLengkap'])->name('laporan.lengkap.create');
        Route::post('/laporan-lengkap/store', [\App\Http\Controllers\AktivitasMbkmController::class, 'storeLaporanLengkap'])->name('laporan.lengkap.store');

        Route::get('mbkm/staff/peserta/{peserta}/edit', [\App\Http\Controllers\PesertaController::class, 'edit'])->name('peserta.edit');
        Route::put('mbkm/staff/peserta/{peserta}', [\App\Http\Controllers\PesertaController::class, 'update'])->name('peserta.update');

        Route::post('/peserta/{id}/upload/{type}', [\App\Http\Controllers\PesertaController::class, 'uploadDocument'])->name('peserta.upload');
        Route::delete('/peserta/{id}/delete/{type}', [\App\Http\Controllers\PesertaController::class, 'destroyFile'])->name('peserta.destroyFile');
        Route::post('/peserta/{id}/upload-multiple', [\App\Http\Controllers\PesertaController::class, 'uploadMultipleDocuments'])->name('peserta.uploadMultiple');

        Route::get('peserta/{ketua}/team/add', [\App\Http\Controllers\PesertaController::class, 'showAddTeamMemberForm'])->name('team.addMemberForm');
        Route::post('peserta/{ketua}/team/add', [\App\Http\Controllers\PesertaController::class, 'addTeamMember'])->name('team.addMember');
        Route::delete('/team/member/{id}/remove', [\App\Http\Controllers\PesertaController::class, 'removeTeamMember'])->name('team.removeMember');

    });

    Route::middleware(['role:mitra'])->group(function () {
        Route::resource('mbkm/staff/mitra', \App\Http\Controllers\MitraProfileController::class)->only(['edit', 'update']);
    });

    Route::middleware(['role:mitra|dosen'])->group(function () {
        Route::get('/staff/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'index'])->name('staff.registrasiIndex');
        Route::put('/staff/registrasi/{id}', [\App\Http\Controllers\RegistrasiController::class, 'update'])->name('staff.updateRegistrasi');
        Route::put('/staff/registrasi/{id}/dospem', [\App\Http\Controllers\RegistrasiController::class, 'updateDospem'])->name('staff.updateDospem');

        Route::get('/laporan', [\App\Http\Controllers\AktivitasMbkmController::class, 'index'])->name('laporan.index');
        Route::post('/laporan-harian/validate/{id}', [\App\Http\Controllers\AktivitasMbkmController::class, 'validateLaporanHarian'])->name('laporan.harian.validate');
        Route::post('/laporan-mingguan/validate/{id}', [\App\Http\Controllers\AktivitasMbkmController::class, 'validateLaporanMingguan'])->name('laporan.mingguan.validate');

        // Tambahkan rute untuk memuat media (gambar) laporan harian
        Route::get('/laporan-harian/media/{id}', [\App\Http\Controllers\AktivitasMbkmController::class, 'getLaporanHarianMedia'])->name('laporan.harian.media');
    });

    Route::middleware(['role:staff|super admin|mitra|peserta'])->group(function () {
        Route::resource('mbkm/staff/mitra', \App\Http\Controllers\MitraProfileController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
        Route::post('mbkm/staff/mitra/json', [\App\Http\Controllers\MitraProfileController::class, 'json'])->name('mitra.json');
        Route::post('mbkm/staff/mitra/create', [\App\Http\Controllers\MitraProfileController::class, 'storeMitraUser'])->name('mitra.user.store');

        Route::resource('mbkm/mitra/lowongan', \App\Http\Controllers\LowonganController::class);
        Route::post('mbkm/mitra/lowongan/json', [\App\Http\Controllers\LowonganController::class, 'json'])->name('lowongan.json');

        Route::post('/temp/storage', [\App\Http\Controllers\StorageController::class, 'store'])->name('storage.store');
        Route::delete('/temp/storage', [\App\Http\Controllers\StorageController::class, 'destroy'])->name('storage.destroy');
        Route::get('/temp/storage/{path}', [\App\Http\Controllers\StorageController::class, 'show'])->name('storage.show');

        Route::resource('mbkm/staff/dospem', \App\Http\Controllers\DosenPembimbingLapanganController::class);
        Route::post('mbkm/staff/dospem/json', [\App\Http\Controllers\DosenPembimbingLapanganController::class, 'json'])->name('dospem.json');

        Route::get('mbkm/staff/peserta', [\App\Http\Controllers\PesertaController::class, 'index'])->name('peserta.index');
        Route::get('mbkm/staff/peserta/create', [\App\Http\Controllers\PesertaController::class, 'create'])->name('peserta.create');
        Route::post('mbkm/staff/peserta', [\App\Http\Controllers\PesertaController::class, 'store'])->name('peserta.store');
        Route::get('mbkm/staff/peserta/{peserta}', [\App\Http\Controllers\PesertaController::class, 'show'])->name('peserta.show');

        Route::delete('mbkm/staff/peserta/{peserta}', [\App\Http\Controllers\PesertaController::class, 'destroy'])->name('peserta.destroy');
        Route::post('mbkm/staff/peserta/json', [\App\Http\Controllers\PesertaController::class, 'json'])->name('peserta.json');

        Route::get('/staff/registrasi', [\App\Http\Controllers\RegistrasiController::class, 'index'])->name('staff.registrasiIndex');
        Route::put('/staff/registrasi/{id}', [\App\Http\Controllers\RegistrasiController::class, 'update'])->name('staff.updateRegistrasi');
        Route::put('/staff/registrasi/{id}/dospem', [\App\Http\Controllers\RegistrasiController::class, 'updateDospem'])->name('staff.updateDospem');

        Route::get('/staff/registrasi/{id}/documents', [\App\Http\Controllers\RegistrasiController::class, 'showDocuments'])->name('registrasi.documents');

    });

    Route::middleware(['role:dosen|super admin'])->group(function () {
        Route::post('/laporan-lengkap/validate/{id}', [\App\Http\Controllers\AktivitasMbkmController::class, 'validateLaporanLengkap'])->name('laporan.lengkap.validate');
    });
});

require __DIR__ . '/auth.php';

Route::resource('mahasiswa', \App\Http\Controllers\sisfo\MahasiswaController::class);
Route::resource('dosen', \App\Http\Controllers\sisfo\DosenController::class);
