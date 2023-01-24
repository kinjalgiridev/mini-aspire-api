<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Loan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoanRepaymentTest extends TestCase
{
    use WithFaker;

    // public function testRequiredFieldsForRepayment()
    // {
    //     //Get token
    //     $token = $this->authenticate();

    //     $loan = Loan::create([
    //         "amount" => $this->faker->unique(true)->numberBetween(1, 100) * 1000,
    //         "term" => $this->faker->unique(true)->numberBetween(3, 48)
    //     ]);

    //     $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->json('PUT', 'api/loan/repayment/', ['Accept' => 'application/json'])
    //         ->assertJson([
    //             "status" => "error",
    //             "message" => [
    //                 "amount" => ["The amount field is required."],
    //                 "term" => ["The term field is required."],
    //             ]
    //         ]);
    // }

    // public function testSuccessfulLoanApply()
    // {
    //     $userData = [
    //         "amount" => $this->faker->unique(true)->numberBetween(1, 100) * 1000,
    //         "term" => $this->faker->unique(true)->numberBetween(3, 48)
    //     ];

    //     //Get token
    //     $token = $this->authenticate();
    //     $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->json('POST', 'api/loan', $userData, ['Accept' => 'application/json'])
    //         ->assertJsonStructure([
    //             "loan" => [
    //                 "amount",
    //                 "term",
    //                 "created_by",
    //                 "updated_by",
    //                 "updated_at",
    //                 "created_at",
    //                 "id"
    //             ],
    //             "message",
    //             "status"
    //         ]);
    // }
}
