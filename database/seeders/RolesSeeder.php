<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
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

        // Masukkan roles ke dalam database
        foreach ($roles as $role) {
            Roles::create($role);
        }
    }
}
