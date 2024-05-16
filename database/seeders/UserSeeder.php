<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) {
            $user = User::create([
                'name' => 'User '.$i,
                'email' => "user$i@mail.com",
                'password' => bcrypt('password'),
            ]);

            $user->assignRole('Super Admin');
        }
    }
}
