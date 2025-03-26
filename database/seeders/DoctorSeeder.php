<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $departments = [
            'Cardiology',
            'Ophthalmology',
            'Pediatrics',
            'Radiology',
            'Urology',
            'Neurology',
            'Orthopedics',
            'Dermatology',
            'Gastroenterology',
            'Endocrinology',
            'Oncology',
            'Psychiatry',
            'Nephrology',
            'Pulmonology',
            'Rheumatology'
        ];

        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('doctors')->truncate();
        DB::table('users')->where('role', 'doctor')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 0; $i < 15; $i++) {
            // First create the user account
            $userId = DB::table('users')->insertGetId([
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('doctor123'), // Default password
                'role' => 'doctor',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Then create the doctor record
            DB::table('doctors')->insert([
                'user_id' => $userId,
                'name' => 'Dr. ' . $faker->name,
                'mobile' => $faker->unique()->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'department' => $departments[$i % count($departments)],
                'availability' => 'available', 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}