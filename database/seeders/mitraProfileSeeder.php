<?php

namespace Database\Seeders;

use App\Models\MitraProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class mitraProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mitraData = [
            [
                'name' => 'Mitra A',
                'address' => 'Alamat Mitra A',
                'phone' => '08123456789',
                'email' => 'mitraa@example.com',
                'website' => 'http://www.mitraa.com',
                'image' => 'mitra_a.jpg',
                'type' => 'Pertukaran Mahasiswa',
                'description' => 'Deskripsi Mitra A.'
            ],
            [
                'name' => 'Mitra B',
                'address' => 'Alamat Mitra B',
                'phone' => '08234567890',
                'email' => 'mitrab@example.com',
                'website' => 'http://www.mitrab.com',
                'image' => 'mitra_b.jpg',
                'type' => 'Magang Merdeka',
                'description' => 'Deskripsi Mitra B.'
            ],
            [
                'name' => 'Mitra C',
                'address' => 'Alamat Mitra C',
                'phone' => '08345678901',
                'email' => 'mitrac@example.com',
                'website' => 'http://www.mitrac.com',
                'image' => 'mitra_c.jpg',
                'type' => 'Kampus Mengajar',
                'description' => 'Deskripsi Mitra C.'
            ],
            [
                'name' => 'Mitra D',
                'address' => 'Alamat Mitra D',
                'phone' => '08456789012',
                'email' => 'mitrad@example.com',
                'website' => 'http://www.mitrab.com',
                'image' => 'mitra_d.jpg',
                'type' => 'Pertukaran Mahasiswa',
                'description' => 'Deskripsi Mitra D.'
            ],
            [
                'name' => 'Mitra E',
                'address' => 'Alamat Mitra E',
                'phone' => '08567890123',
                'email' => 'mitrae@example.com',
                'website' => 'http://www.mitrac.com',
                'image' => 'mitra_e.jpg',
                'type' => 'Magang Merdeka',
                'description' => 'Deskripsi Mitra E.'
            ],
            [
                'name' => 'Mitra F',
                'address' => 'Alamat Mitra F',
                'phone' => '08678901234',
                'email' => 'mitraf@example.com',
                'website' => 'http://www.mitrab.com',
                'image' => 'mitra_f.jpg',
                'type' => 'Kampus Mengajar',
                'description' => 'Deskripsi Mitra F.'
            ],
            [
                'name' => 'Mitra G',
                'address' => 'Alamat Mitra G',
                'phone' => '08789012345',
                'email' => 'mitrag@example.com',
                'website' => 'http://www.mitrac.com',
                'image' => 'mitra_g.jpg',
                'type' => 'Pertukaran Mahasiswa',
                'description' => 'Deskripsi Mitra G.'
            ],
        ];

        // Insert data ke tabel mitra_profile
        foreach ($mitraData as $data) {
            MitraProfile::create($data);
        }
    }
}
