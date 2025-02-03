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

    public const IMAGE_FOLDER = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'customer_code',
        'customer_type_id',
        'contact_name',
        'print_name',
        'parent_customer_id',
        'referred_by_id',
        'phone',
        'phone_2',
        'mobile',
        'fax',
        'email',
        'acoount_email',
        'url',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        'county',
        'country_id',
        'customer_image',
        'shipping_address',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_county',
        'shipping_country_id',
        'parent_location_id',
        'multi_location',
        'generic_customer',
        'route_location_id',
        'is_po_required',
        'apply_finance_charge',
        'preferred_document_id',
        'grace_period',
        'hold_days',
        'since_date',
        'tax_number',
        'sales_person_id',
        'secondary_sales_person_id',
        'price_list_label_id',
        'is_tax_exempt',
        'tax_exempt_reason_id',
        'sales_tax_id',
        'payment_terms_id',
        'exempt_certificate_no',
        'exempt_expiry_date',
        'about_us_option_id',
        'project_type_id',
        'end_use_segment_id',
        'default_fulfillment_method_id',
        'credit_limit',
        'is_credit_lock',
        'sales_alert_note',
        'sales_lock_note',
        'is_allow_login',
        'username',
        'password',
        'delivery_instructions',
        'collection_notes',
        'internal_notes',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            $lastCustomer = Customer::orderBy('id', 'desc')->first();
            $nextCustomerCode = $lastCustomer ? 'CUST' . str_pad((int)substr($lastCustomer->customer_code, 4) + 1, 4, '0', STR_PAD_LEFT) : 'CUST0001';
            $customer->customer_code = $nextCustomerCode;
        });
    }

    public function customer_type()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function shipping_country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function parent_location()
    {
        return $this->belongsTo(Company::class, 'parent_location_id');
    }

    public function sales_person()
    {
        return $this->belongsTo(User::class, 'sales_person_id', 'id');
    }

    public function secondary_sales_person()
    {
        return $this->belongsTo(User::class, 'secondary_sales_person_id', 'id');
    }

    public function price_list_label()
    {
        return $this->belongsTo(PriceListLabel::class, 'price_list_label_id', 'id');
    }

    public function tax_exempt_reason()
    {
        return $this->belongsTo(TaxExemptReason::class, 'tax_exempt_reason_id', 'id');
    }

    public function payment_term()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_terms_id', 'id');
    }

    public function sales_tax()
    {
        return $this->belongsTo(Account::class, 'sales_tax_id', 'id');
    }

    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'billing_customer_id', 'id');
    }
    public function saleOrder()
    {
        return $this->hasMany(SaleOrder::class, 'billing_customer_id', 'id');
    }
    public function consignments()
    {
        return $this->hasMany(Consignment::class, 'consignment_location_id', 'id');
    }
    public function hold()
    {
        return $this->hasMany(Hold::class, 'billing_customer_id', 'id');
    }
}
