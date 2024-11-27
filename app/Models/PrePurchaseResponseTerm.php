<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrePurchaseResponseTerm extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'pre_purchase_response_terms';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
        'supplier_id',
        'pre_purchase_request_id',
        'requested_by_name',
        'requested_payment_terms',
        'requested_shipment_terms',
        'required_ship_date',
        'response_payment_terms',
        'response_shipment_term_id',
        'response_shipment_terms',
        'response_ship_date',
   ];
}
