<?php

namespace Database\Seeders;

use App\Models\DosenPembimbingLapangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DosenPembimbingLapangan::create([
            'users_id' => 1,
            'roles_id' => 1,
            'name' => 'Nama Dosen Pembimbing 1',
            'image' => 'nama_file_gambar_1.jpg',
        ]);

        DosenPembimbingLapangan::create([
            'users_id' => 2,
            'roles_id' => 2,
            'name' => 'Nama Dosen Pembimbing 2',
            'image' => 'nama_file_gambar_2.jpg',
        ]);

        DosenPembimbingLapangan::create([
            'users_id' => 3,
            'roles_id' => 3,
            'name' => 'Nama Dosen Pembimbing 3',
            'image' => 'nama_file_gambar_3.jpg',
        ]);
    }
    
}
