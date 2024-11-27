<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrePurchaseRequestSupplierRequest extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pre_purchase_request_supplier_requests';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'supplier_id',
        'supplier_address',
        'supplier_suite',
        'supplier_city',
        'supplier_state',
        'supplier_zip',
        'supplier_country_id',
        'payment_term_id',
        'shipment_term_id',
        'pre_purchase_request_id',
        'email',
        'email_body',
        'required_ship_date',
        'requested_by_id',
        'pre_purchase_terms',
        'status',
        'resend_request',
        'response_ship_date',
        'update_response',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by_id', 'id');
    }

    public function shipment_term()
    {
        return $this->belongsTo(ShipmentTerm::class, 'shipment_term_id', 'id');
    }

    public function account_payment_term()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_term_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'supplier_country_id', 'id');
    }

    public function pre_purchase_request()
    {
        return $this->belongsTo(PrePurchaseRequest::class, 'pre_purchase_request_id', 'id');
    }
}
