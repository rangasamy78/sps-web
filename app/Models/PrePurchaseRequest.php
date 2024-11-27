<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrePurchaseRequest extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'pre_purchase_requests';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
        'transaction_number',
        'pre_purchase_date',
        'required_ship_date',
        'eta_date',
        'shipment_term_id',
        'requested_by_id',
        'supplier_id',
        'supplier_primary_address',
        'supplier_address',
        'supplier_suite',
        'supplier_city',
        'supplier_state',
        'supplier_zip',
        'supplier_country_id',
        'payment_term_id',
        'purchase_location_id',
        'purchase_location_address',
        'purchase_location_suite',
        'purchase_location_city',
        'purchase_location_state',
        'purchase_location_zip',
        'purchase_location_country_id',
        'ship_to_location_id',
        'ship_to_location_attn',
        'ship_to_location_address',
        'ship_to_location_suite',
        'ship_to_location_city',
        'ship_to_location_state',
        'ship_to_location_zip',
        'ship_to_location_country_id',
        'printed_notes',
        'internal_notes',
        'special_instruction_id',
        'special_instructions',
        'pre_purchase_term_id',
        'terms',
        'conversion_rate',
   ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($request) {
            $lastRequest = PrePurchaseRequest::orderBy('id', 'desc')->first();
            $nextTransactionNumber = $lastRequest ? (int)$lastRequest->transaction_number + 1 : 1;
            $request->transaction_number = $nextTransactionNumber;
        });
    }

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
}
