<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password'),
                'address' => '123 Main St',
                'sex' => 'Laki-laki',
                'job' => 'Developer',
                'birth_date' => Carbon::now()->subYears(25)->format('Y-m-d'),
                'phone_number' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
                'password' => Hash::make('password'),
                'address' => '456 Elm St',
                'sex' => 'Perempuan',
                'job' => 'Designer',
                'birth_date' => Carbon::now()->subYears(30)->format('Y-m-d'),
                'phone_number' => '0987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users if needed
        ];

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 18; $i++) {
            $birthDate = Carbon::now()->subYears(rand(16, 40))->format('Y-m-d');
            
            $users[$i] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'address' => $faker->address,
                'sex' => $i % 2 == 0 ? 'Laki-laki' : 'Perempuan',
                'job' => $faker->jobTitle,
                'birth_date' => $birthDate,
                'phone_number' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);
    }
}
