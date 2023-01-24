<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\CreatedUpdatedBy;
use App\Models\Loan;

class LoanRepayment extends LoanBaseModel
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'amount',
        'status',
        'due_date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function checkUpdateLoan()
    {
        $countLoanRepayments = LoanRepayment::where('loan_id', '=', $this->loan_id)
            ->where('status', '=', 0)
            ->count();

        if ($countLoanRepayments === 0) {
            $loan = Loan::findOrFail($this->loan_id);
            $loan->update([
                'status' => Loan::PAID,
            ]);
        }
    }
}
