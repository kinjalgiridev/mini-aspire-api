<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LoanBaseModel extends Model
{
    public const PENDING = 0;
    public const APPROVED = 1;
    public const PAID = 2;

    /**
     * Return list of status codes and labels

     * @return array
     */
    public static function listStatus()
    {
        return [
            self::PENDING    => 'Pending',
            self::APPROVED => 'Approved',
            self::PAID  => 'Paid'
        ];
    }

    /**
     * Get the loan status in human readable form
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->listStatus()[$value],
        );
    }

    /**
     * Returns label of actual status

     * @param string
     */
    public function statusLabel()
    {
        $list = self::listStatus();

        // little validation here just in case someone mess things
        // up and there's a ghost status saved in DB
        return isset($list[$this->status])
            ? $list[$this->status]
            : $this->status;
    }

    /**
     * Some actions will happen only if it's pending, so I have 
     * this method for making things easier
     * @return Boolean
     */
    public function isPending()
    {
        return $this->status == "Pending";
    }

    /**
     * Some actions will happen only if it's paid, so I have 
     * this method for making things easier
     * @return Boolean
     */
    public function isPaid()
    {
        return $this->status == "Paid";
    }

    /**
     * Some actions will happen only if it's approved, so I have 
     * this method for making things easier
     * @return Boolean
     */
    public function isApproved()
    {
        return $this->status == "Approved";
    }
}
