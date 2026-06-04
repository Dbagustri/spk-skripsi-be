<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make(
                    'password123'
                ),
            ]
        );

        $admin->assignRole('admin');


        $user = User::firstOrCreate(
            [
                'email' => 'user@gmail.com'
            ],
            [
                'name' => 'Mahasiswa',
                'password' => Hash::make(
                    'password123'
                ),
            ]
        );

        $user->assignRole('user');
    }
}
