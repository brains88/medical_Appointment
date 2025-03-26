<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

    $doctors = [];

    for ($i = 0; $i < 15; $i++) {
        $doctors[] = [
            'name' => 'Dr. ' . $faker->name,
            'mobile' => $faker->unique()->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'department' => $departments[$i % count($departments)],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    DB::table('doctors')->insert($doctors);
}
}
