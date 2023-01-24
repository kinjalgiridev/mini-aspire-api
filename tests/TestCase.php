<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    //Create user and authenticate the user
    protected function authenticate()
    {
        $user = User::create([
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            'role_id' => 2,
            'password' => Hash::make('secret1234'),
        ]);
        $token = JWTAuth::fromUser($user);
        return $token;
    }
}
