<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanRepaymentController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // get current logged in user
            $user = Auth::user();

            // load loan repayment
            $loanRepayment = LoanRepayment::find($id);

            if ($user->can('update', $loanRepayment)) {

                $validator = Validator::make($request->all(), [
                    'amount' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => $validator->getMessageBag()
                        ],
                        200
                    );
                } else {
                    if ($loanRepayment->isPaid()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This loan repayment paid already',
                            'loan' => $loanRepayment,
                        ]);
                    }

                    if ($request->amount < $loanRepayment->amount) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Loan repayment amount is less than required amount of ' . $loanRepayment->amount,
                            'loan' => $loanRepayment
                        ]);
                    }

                    $loanRepayment->update([
                        'status' => LoanRepayment::PAID,
                    ]);

                    $loanRepayment = LoanRepayment::findOrFail($id);

                    $loanRepayment->checkUpdateLoan();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Loan repayment paid successfully',
                        'loan' => $loanRepayment
                    ]);
                }
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Not Authorized'
                    ],
                    403
                );
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 200);
        }
    }
}
