<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ////////////////////////////////////////////////is staff////////////////////////////////////////////////
            ///////////Kampus Mengajar////////////
            'create_km_lolos_seleksi',
            'read_km_lolos_seleksi',
            'update_km_lolos_seleksi',
            'delete_km_lolos_seleksi',
            'create_km_tidak_lolos_seleksi',
            'read_km_tidak_lolos_seleksi',
            'update_km_tidak_lolos_seleksi',
            'delete_km_tidak_lolos_seleksi',
            'create_km_pendaftaran',
            'read_km_pendaftaran',
            'update_km_pendaftaran',
            'delete_km_pendaftaran',
            ///////////Magang Merdeka////////////
            'create_mm_lolos_seleksi',
            'read_mm_lolos_seleksi',
            'update_mm_lolos_seleksi',
            'delete_mm_lolos_seleksi',
            'create_mm_tidak_lolos_seleksi',
            'read_mm_tidak_lolos_seleksi',
            'update_mm_tidak_lolos_seleksi',
            'delete_mm_tidak_lolos_seleksi',
            'create_mm_pendaftaran',
            'read_mm_pendaftaran',
            'update_mm_pendaftaran',
            'delete_mm_pendaftaran',
            ///////////Pertukaran Mahasiswa////////////
            'create_pm_lolos_seleksi',
            'read_pm_lolos_seleksi',
            'update_pm_lolos_seleksi',
            'delete_pm_lolos_seleksi',
            'create_pm_tidak_lolos_seleksi',
            'read_pm_tidak_lolos_seleksi',
            'update_pm_tidak_lolos_seleksi',
            'delete_pm_tidak_lolos_seleksi',
            'create_pm_pendaftaran',
            'read_pm_pendaftaran',
            'update_pm_pendaftaran',
            'delete_pm_pendaftaran',
            ///////////Dosen Pembimbing Lapangan////////////
            'create_dpl',
            'read_dpl',
            'update_dpl',
            'delete_dpl',
            ///////////Mitra////////////
            'create_km_lowongan',
            'read_km_lowongan',
            'update_km_lowongan',
            'delete_km_lowongan',
            'create_mm_lowongan',
            'read_mm_lowongan',
            'update_mm_lowongan',
            'delete_mm_lowongan',
            'create_pm_lowongan',
            'read_pm_lowongan',
            'update_pm_lowongan',
            'delete_pm_lowongan',
            'create_km_mitra_profil',
            'read_km_mitra_profil',
            'update_km_mitra_profil',
            'delete_km_mitra_profil',
            'create_mm_mitra_profil',
            'read_mm_mitra_profil',
            'update_mm_mitra_profil',
            'delete_mm_mitra_profil',
            'create_pm_mitra_profil',
            'read_pm_mitra_profil',
            'update_pm_mitra_profil',
            'delete_pm_mitra_profil',
            ////////////////////////////////////////////////is peserta////////////////////////////////////////////////
            'daftar_km',
            'dafatar_mm',
            'daftar_pm',
            'read_km_laporan_harian',
            'update_km_laporan_harian',
            'delete_km_laporan_harian',
            'create_mm_laporan_harian',
            'read_mm_laporan_harian',
            'update_mm_laporan_harian',
            'delete_mm_laporan_harian',
            'create_pm_laporan_harian',
            'read_pm_laporan_harian',
            'update_pm_laporan_harian',
            'delete_pm_laporan_harian',
            'create_km_laporan_harian',
            'read_km_laporan_mingguan',
            'update_km_laporan_mingguan',
            'delete_km_laporan_mingguan',
            'create_mm_laporan_mingguan',
            'read_mm_laporan_mingguan',
            'update_mm_laporan_mingguan',
            'delete_mm_laporan_mingguan',
            'create_pm_laporan_mingguan',
            'read_pm_laporan_mingguan',
            'update_pm_laporan_mingguan',
            'delete_pm_laporan_mingguan',
            'create_km_laporan_lengkap',
            'read_km_laporan_lengkap',
            'update_km_laporan_lengkap',
            'delete_km_laporan_lengkap',
            'create_mm_laporan_lengkap',
            'read_mm_laporan_lengkap',
            'update_mm_laporan_lengkap',
            'delete_mm_laporan_lengkap',
            'create_pm_laporan_lengkap',
            'read_pm_laporan_lengkap',
            'update_pm_laporan_lengkap',
            'delete_pm_laporan_lengkap',
            ////////////////////////////////////////////////is dosen////////////////////////////////////////////////
            'update_km_validasi_laporan_lengkap',
            'update_mm_validasi_laporan_lengkap',
            'update_pm_validasi_laporan_lengkap',
            ////////////////////////////////////////////////is mitra////////////////////////////////////////////////
            'update_km_valiidasi_laporan_harian',
            'update_mm_valiidasi_laporan_harian',
            'update_pm_valiidasi_laporan_harian',
            'update_km_valiidasi_laporan_mingguan',
            'update_mm_valiidasi_laporan_mingguan',
            'update_pm_valiidasi_laporan_mingguan',
            'create_user',
            'read_user',
            'update_user',
            'delete_user',
            'create_role',
            'read_role',
            'update_role',
            'delete_role',
            'create_permission',
            'read_permission',
            'update_permission',
            'delete_permission',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
