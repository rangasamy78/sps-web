<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteReceiveDeposit extends Model
{
    use HasFactory;
    protected $fillable = ['quote_id', 'customer_id', 'cash_account_id', 'receipt_code', 'deposit_date', 'payment_method_id', 'reference', 'reference_date', 'authorization', 'check_date', 'check_code', 'receive_amount', 'net_amount_due', 'quote_amount_percentage', 'address', 'suite', 'city', 'state', 'zip', 'memo', 'account_id', 'location_id', 'description', 'amount', 'internal_notes'];
    protected $table = 'quote_receive_deposits';

    function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
