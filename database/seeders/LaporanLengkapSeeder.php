<?php

namespace Database\Seeders;

use App\Models\LaporanLengkap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanLengkapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'peserta_id' => 1,
                'is_validate' => 1,
                'document' => 'nama_file_document_1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'peserta_id' => 2,
                'is_validate' => 0,
                'document' => 'nama_file_document_2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $row) {
            LaporanLengkap::create($row);
        }
    }
}
