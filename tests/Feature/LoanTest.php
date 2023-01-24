<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoanTest extends TestCase
{
    use WithFaker;

    public function testRequiredFieldsForLoanApply()
    {
        //Get token
        $token = $this->authenticate();
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', 'api/loan', ['Accept' => 'application/json'])
            ->assertJson([
                "status" => "error",
                "message" => [
                    "amount" => ["The amount field is required."],
                    "term" => ["The term field is required."],
                ]
            ]);
    }

    public function testSuccessfulLoanApply()
    {
        $loanData = [
            "amount" => $this->faker->unique(true)->numberBetween(1, 100) * 1000,
            "term" => $this->faker->unique(true)->numberBetween(3, 48)
        ];

        //Get token
        $token = $this->authenticate();
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', 'api/loan', $loanData, ['Accept' => 'application/json'])
            ->assertJsonStructure([
                "loan" => [
                    "amount",
                    "term",
                    "created_by",
                    "updated_by",
                    "updated_at",
                    "created_at",
                    "id"
                ],
                "message",
                "status"
            ]);
    }

    public function testAdminApproveLoan()
    {
        $loanData = [
            "amount" => $this->faker->unique(true)->numberBetween(1, 100) * 1000,
            "term" => $this->faker->unique(true)->numberBetween(3, 48)
        ];

        //Get token
        $token = $this->authenticate();
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', 'api/loan', $loanData, ['Accept' => 'application/json'])
            ->assertJsonStructure([
                "loan" => [
                    "amount",
                    "term",
                    "created_by",
                    "updated_by",
                    "updated_at",
                    "created_at",
                    "id"
                ],
                "message",
                "status"
            ]);
    }
}
