<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_name',
        'print_name',
        'code',
        'contact_name',
        'supplier_type_id',
        'parent_location_id',
        'multi_location_supplier',
        'language_id',
        'parent_supplier_id',
        'supplier_since',
        'supplier_port_id',
        'markup_multiplier',
        'discount',
        'primary_phone',
        'secondary_phone',
        'mobile',
        'fax',
        'email',
        'website',
        'remit_address',
        'remit_suite',
        'remit_city',
        'remit_state',
        'remit_zip',
        'remit_country_id',
        'ship_address',
        'ship_suite',
        'ship_city',
        'ship_state',
        'ship_zip',
        'ship_country_id',
        'credit_limit',
        'ein_number',
        'account',
        'currency_id',
        'payment_terms_id',
        'shipment_terms_id',
        'purchase_tax_id',
        'frieght_forwarder_id',
        'default_payment_method_id',
        'shipping_instruction',
        'internal_notes',
        'allow_access_to_supplier',
        'supplier_username',
        'supplier_password',
        'form_1099_printed',
        'status',
    ];
    protected $table = 'suppliers';

    public function supplier_type()
    {
        return $this->belongsTo(SupplierType::class, 'supplier_type_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function location()
    {
        return $this->belongsTo(Company::class, 'parent_location_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function payment_term()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_terms_id');
    }
    public function shipment_term()
    {
        return $this->belongsTo(ShipmentTerm::class, 'shipment_terms_id');
    }
    public function supplier_port()
    {
        return $this->belongsTo(SupplierPort::class, 'supplier_port_id');
    }
    public function remit_country()
    {
        return $this->belongsTo(Country::class, 'remit_country_id');
    }

}
