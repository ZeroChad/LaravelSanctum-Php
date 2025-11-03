<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {
        $users = [
            [
                'email' => 'admintest@.com',
                'password' => Hash::make('password123'),
                'first_name' => 'Admin',
                'last_name' => 'Test',
            ],
            [
                'email' => 'usertest@.com',
                'password' => Hash::make('password123'),
                'first_name' => 'User',
                'last_name' => 'Test',
            ],
            [
                'email' => 'stocker@.com',
                'password' => Hash::make('password123'),
                'first_name' => 'Stocker',
                'last_name' => 'Test',
            ],
            [
                'email' => 'clienttest@.com',
                'password' => Hash::make('password123'),
                'first_name' => 'Client',
                'last_name' => 'Test',
            ],
            [
                'email' => 'UserTest@.com',
                'password' => Hash::make('password123'),
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
        ];

        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create([
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'sex' => 'male',
                    'role' => $userData['role'],
                    'birthday' => now()->subYears(25)->format('Y-m-d'),
                ]);

                echo "Created {$userData['role']} account:{$userData['email']}\n";
            }
        }
    }
}
