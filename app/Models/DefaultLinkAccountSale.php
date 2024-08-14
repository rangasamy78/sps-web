<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultLinkAccountSale extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'default_link_account_sales';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_ar_id',
        'sales_income_product_id',
        'sales_income_service_id',
        'cogs_account_id',
        'restocking_fee_income_account_id',
        'sales_tax_liability_account_id',
        'sales_discount_id',
    ];
}
