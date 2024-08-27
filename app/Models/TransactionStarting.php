<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionStarting extends Model
{
    use HasFactory;

    protected $table = 'transaction_startings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'po_starting_number',
        'supplier_invoice_starting_number',
        'pre_sale_starting_number',
        'sale_order_starting_number',
        'delivery_starting_number',
        'invoice_starting_number',
        'finance_charge_invoice_starting_number',
    ];
}
