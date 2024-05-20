<?php

namespace Database\Seeders;

use App\Models\Role;
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
        // for ($i=0; $i < 5; $i++) {
        //     $user = User::create([
        //         'name' => 'User '.$i,
        //         'email' => "user$i@mail.com",
        //         'password' => bcrypt('password'),
        //     ]);

        //     $user->assignRole('super admin');
        // }

        $roles = Role::all();
        // create 100 fake users per role, i without factory
        foreach ($roles as $role) {
            for ($i = 0; $i < 100; $i++) {
                $user = User::create([
                    'name' => $role->name . ' ' . $i,
                    'email' => fake()->email(),
                    'password' => bcrypt('12345678'),
                ]);
                $user->assignRole($role->name);
            }
        }
    }
}
