<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()
            ->whereHas('mitraProfile')->get();

        foreach ($users as $user) {
            foreach (range(1, 5) as $index) {
                Lowongan::create([
                    'name' => fake()->jobTitle(),
                    'mitra_id' => $user->mitraProfile->id,
                    'description' => fake()->sentence(),
                    'quota' => fake()->numberBetween(5, 20),
                    'is_open' => true,
                    'location' => fake()->city(),
                    'gpa' => '3.0',
                    'semester' => '6',
                    'experience_required' => 'Pengalaman minimal 1 tahun',
                    'start_date' => now(),
                    'end_date' => now()->addMonth(),
                ]);
            }
        }

        // Lowongan::create([
        //     'name' => 'Lowongan A',
        //     'mitra_id' => 1, // Ganti dengan id mitra yang sesuai
        //     'description' => 'Deskripsi lowongan A',
        //     'quota' => 5,
        //     'is_open' => true,
        //     'location' => 'Jakarta',
        //     'gpa' => '3.0',
        //     'semester' => '6',
        //     'experience_required' => 'Pengalaman minimal 1 tahun',
        //     'start_date' => '2024-06-01',
        //     'end_date' => '2024-07-01',
        // ]);
    }
}
