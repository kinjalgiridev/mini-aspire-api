<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    "name" => "Customer One",
                    "email" => 'customer1@test.com',
                    'role_id' => 2,
                    'password' => Hash::make('Customer@123'),
                ],
                [
                    "name" => "Customer Two",
                    "email" => 'customer2@test.com',
                    'role_id' => 2,
                    'password' => Hash::make('Customer@123'),
                ],
                [
                    "name" => "Admin One",
                    "email" => 'admin1@test.com',
                    'role_id' => 1,
                    'password' => Hash::make('Admin@123'),
                ],
            ]
        );
    }
}
