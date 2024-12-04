<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expenditure extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'expenditures';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
    protected $fillable = [
       'expenditure_name',
       'print_name',
       'expenditure_code',
       'expenditure_type_id',
       'parent_location_id',
       'contact_name',
       'since_date',
       'primary_phone',
       'secondary_phone',
       'mobile',
       'fax',
       'email',
       'website',
       'address',
       'suite',
       'city',
       'state',
       'zip',
       'country_id',
       'shipping_address',
       'shipping_suite',
       'shipping_city',
       'shipping_state',
       'shipping_zip',
       'shipping_country_id',
       'payment_terms',
       'currency',
       'expense_account_id',
       'payment_method_id',
       'account',
       'tax',
       'memo',
       'ein',
       'is_generic_expenditure',
       'is_print_1099',
       'is_frieght_expenditure',
       'is_sub_contractor',
       'is_allow_login',
       'expenditure_username',
       'expenditure_password',
       'internal_notes'

    ];

    public function vendor_types()
    {
        return $this->belongsTo(VendorType::class, 'expenditure_type_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'parent_location_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    
    public function expenditure()
    {
        return $this->belongsTo(Expenditure::class, 'vendor_id');
    }
    public function vendorType()
    {
        return $this->belongsTo(VendorType::class, 'expenditure_type_id', 'id');
    }

}