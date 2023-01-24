<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\CreatedUpdatedBy;
use Carbon\Carbon;

class Loan extends LoanBaseModel
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'amount',
        'term',
        'status',
        'due_date',
        'approved_date'
    ];

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function createRepayments()
    {
        $repayments = [];
        $repaymentAmount = $this->amount / $this->term;

        for ($i = 0; $i < $this->term; $i++) {
            $repayments[] = [
                'amount' => $repaymentAmount,
                'due_date' => Carbon::parse(Carbon::now()->copy()->addWeeks($i + 1))
            ];
        }

        return $repayments;
    }
}
