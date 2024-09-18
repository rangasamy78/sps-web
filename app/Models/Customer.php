<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'customers';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
        'customer_name',
        'customer_code',
        'mt_sub_type',
        'print_name',
        'legacy_id',
        'contact_name',
        'mt_referred_by',
        'phone_1',
        'phone_2',
        'fax',
        'mobile',
        'email',
        'url',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        'mt_country',
        'shipping_address',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'mt_shipping_country',
        'mt_location',
        'is_multi_location',
        'mt_route',
        'mt_sales_rep_id',
        'mt_price_level',
        'mt_price_level_2',
        'mt_payment_terms',
        'mt_sales_tax',
        'is_tax_exempt',
        'tax_exempt_reason',
        'exempt_certificate_no',
        'exempt_expiry_date',
        'is_po_required',
        'apply_finance_charge',
        'preferred_document_delivery_mode',
        'mt_currency',
        'since_date',
        'tax_number',
        'mt_language',
        'credit_limit',
        'past_due_alert',
        'lock_alert',
        'is_allow_login',
        'username',
        'password',
        'delivery_instructions',
        'internal_notes',
   ];

   protected function name(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
   }

}
