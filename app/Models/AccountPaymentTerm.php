<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountPaymentTerm extends Model
{
    use HasFactory;
    protected $table = 'account_payment_terms';
    protected $fillable = [
        'payment_standard_date_driven',
        'payment_code',
        'payment_label',
        'payment_type',
        'payment_net_due_day',
        'payment_not_used_sales',
        'payment_not_used_purchases',
        'payment_discount_percent',
        'payment_threshold_days',
    ];
}