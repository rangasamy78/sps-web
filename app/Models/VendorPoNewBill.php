<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPoNewBill extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_po_id', 'transaction_number', 'invoice_number', 'invoice_date', 'payments_terms_id', 'due_date',
        'contact_location_id', 'hold_payment_check', 'hold_payment_reason'];
    protected $table = 'vendor_po_new_bills';

    public function vendorPo()
    {
        return $this->belongsTo(VendorPo::class, 'vendor_po_id');
    }
    public function payment_terms()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payments_terms_id');
    }

    public function vendor_po_new_bills()
    {
        return $this->hasMany(VendorPoNewBillDetails::class, 'vendor_po_bill_id');
    }
    public function company()
    {
        return $this->hasMany(Company::class, 'contact_location_id');
    }
  
    
}