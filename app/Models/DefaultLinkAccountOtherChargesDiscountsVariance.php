<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultLinkAccountOtherChargesDiscountsVariance extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'default_link_account_other_charges_discounts_variances';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'other_charges_in_po_sipl_id',
        'payments_discount_id',
        'restocking_fees_on_pur_return_id',
        'freight_account_on_purchase_id',
        'supplier_invoice_variance_id',
        'supp_credit_memos_variance_id',
    ];

}
