<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPoNewBillDetails extends Model
{
    use HasFactory;
    protected $_table    = 'vendor_po_new_bills_details';
    protected $_fillable = [
        'bill_check',
        'vendor_po_id',
        'account_id',
        'location_id',
        'service',
        'purchase_check',
        'purchase',
        'description',
        'quantity',
        'uom',
        'unit_cost',
        'extended',
    ];
}