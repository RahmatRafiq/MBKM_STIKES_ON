<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat roles untuk dosen, super admin, staff, peserta, dan mitra
        $roles = [
            ['name' => 'Dosen'],
            ['name' => 'Super Admin'],
            ['name' => 'Staff'],
            ['name' => 'Peserta'],
            ['name' => 'Mitra'],
        ];

        // Masukkan roles ke dalam database dengan menggunakan model Roles
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
