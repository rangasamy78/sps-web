<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPo extends Model
{
    use HasFactory;
    protected $table = 'vendor_pos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_number',
        'vendor_id',
        'location_id',
        'transaction_date',
        'eta_date',
        'payment_term_id',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'country_id',
        'phone',
        'fax',
        'email',
        'extended_total',
        'printed_notes',
        'internal_notes',
        'vendor_po_terms_id',
        'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Expenditure::class, 'vendor_id');
    }
    public function payment_terms()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_term_id');
    }
    public function vendor_po_details()
    {
        return $this->hasMany(VendorPoDetails::class, 'vendor_po_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function location()
    {
        return $this->belongsTo(Company::class, 'location_id');
    }
    public function expenditure()
    {
        return $this->belongsTo(Expenditure::class, 'vendor_id');
    }
}