<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPoPrepayment extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_po_id', 'cash_account_id', 'payment_date','date_on_check', 'check', 'payment_method_id',
        'memo', 'account_id', 'description','amount', 'internal_notes', 'vendor_po_total','misc_amount', 'net_amount_due', 
        'po_percentage'];
    protected $table = 'vendor_po_prepayments';
}