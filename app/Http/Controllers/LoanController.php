<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // get current logged in user
            $user = Auth::user();

            // load article
            $loans = Loan::where(function ($query) use ($user) {
                if (!$user->isAdmin()) {
                    $query->where('created_by', "=", $user->id);
                }
            })->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Loans returned successfully',
                'data' => $loans
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // get current logged in user
            $user = Auth::user();

            // load loan
            $loan = Loan::with('repayments')->findOrFail($id);

            if ($user->can('view', $loan)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Loans returned successfully',
                    'data' => $loan
                ], 200);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|integer|min:1000',
                'term' => 'required|integer|min:3',
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
                $loan = Loan::create([
                    'amount' => $request->amount,
                    'term' => $request->term,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Loan applied successfully',
                    'loan' => $loan
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 200);
        }
    }

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

            // load article
            $loan = Loan::find($id);

            if ($user->can('update', $loan)) {

                $validator = Validator::make($request->all(), [
                    'status' => 'required|integer',
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
                    if ($loan->isApproved() && $request->status == Loan::APPROVED) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Loan approved already',
                            'loan' => $loan
                        ]);
                    }

                    $date = Carbon::now();
                    $end = $date->copy()->addWeeks($loan->term);

                    $loan->update([
                        'status' => $request->status,
                        'due_date' => Carbon::parse($end),
                        'approved_date' => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->toDateTimeString()
                    ]);

                    $repayments = $loan->createRepayments();
                    $loan->repayments()->createMany($repayments);

                    $loan = Loan::findOrFail($id);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Loan approved successfully',
                        'loan' => $loan,
                        'date' => $end
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
