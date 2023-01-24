<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    use WithFaker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                "name" => $this->faker->name,
                "email" => 'customer1@test.com',
                'role_id' => 2,
                'password' => Hash::make('Customer@123'),
            ],
            [
                "name" => $this->faker->name,
                "email" => 'customer2@test.com',
                'role_id' => 2,
                'password' => Hash::make('Customer@123'),
            ],
            [
                "name" => $this->faker->name,
                "email" => 'admin1@test.com',
                'role_id' => 1,
                'password' => Hash::make('Admin@123'),
            ],
        );
    }
}
