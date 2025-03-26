<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            [
                'email' => 'admin@medical.com',
                'password' => Hash::make('password123'), // Correct way to hash password
                'role' => 'admin',
                'created_at' => now(), // Add timestamps
                'updated_at' => now(),
            ],
            [
                'email' => 'doctor@medical.com',
                'password' => Hash::make('password123'), // Correct way to hash password
                'role' => 'doctor',
                'created_at' => now(), // Add timestamps
                'updated_at' => now(),
            ],
            [
                'email' => 'patient@medical.com',
                'password' => Hash::make('password123'), // Correct way to hash password
                'role' => 'patient',
                'created_at' => now(), // Add timestamps
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}