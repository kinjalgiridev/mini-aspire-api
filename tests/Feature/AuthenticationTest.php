<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertJson([
                "status" => "error",
                "message" => [
                    "name" => ["The name field is required."],
                    "role_id" => ["The role id field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                    "password_confirmation" => ["The password confirmation field is required."],
                ]
            ]);
    }

    public function testEmailAlreadyExistsForRegistration()
    {
        $user = User::where('role_id', 2)->first();

        $userData = [
            "name" => $this->faker->name,
            "email" => $user->email,
            "password" => "Demo@12345",
            "password_confirmation" => "Demo@12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertJson([
                "status" => "error",
                "message" => [
                    "email" => ["The email has already been taken."],
                ]
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            "password" => "Demo@12345",
            "password_confirmation" => "Demo@1234",
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertJson([
                "status" => "error",
                "message" => [
                    "password_confirmation" => ["The password confirmation and password must match."],
                ]
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            "role_id" => 2,
            "password" => "Demo@12345",
            "password_confirmation" => "Demo@12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertJsonStructure([
                "user" => [
                    'id',
                    'name',
                    'email',
                    'role_id',
                    'created_at',
                    'updated_at',
                ],
                "access_token",
                "message",
                "status"
            ]);
    }
    
}
