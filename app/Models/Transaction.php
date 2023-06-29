<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'transaction_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'user_id',
        'admin_id',
        'order_id',
        'payment_type',
        'email',
        'contact_no',
        'amount',
        'txn_id',
        'txn_amount',
        'txn_date',
        'txn_payment_mode',
        'txn_bank_txn_id',
        'txn_status',
        'txn_response_code',
        'txn_response_msg',
        'response'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'response' => 'array',
        'ref_response' => 'array',
    ];

    /**
     * Get the student associated with the transaction.
     */
    public function student()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function paidFees()
    {
        return $this->hasOne(PaidFees::class, 'transaction_id', 'transaction_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'admin_id', 'admin_id');
    }
}
