<?php

namespace App\Policies;

use App\Models\LoanRepayment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LoanRepaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LoanRepayment $loanRepayment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LoanRepayment $loanRepayment)
    {
        return ($user->id === $loanRepayment->created_by || $user->role_id === 1)
        ? Response::allow()
        : Response::deny('You do not own this loan.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LoanRepayment $loanRepayment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LoanRepayment $loanRepayment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LoanRepayment $loanRepayment)
    {
        //
    }
}
