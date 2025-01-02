<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteProductPriceCalculator extends Model
{
    use HasFactory;

    protected $fillable = ['quote_product_id', 'supplier_id', 'supplier_unit_cost', 'subtotal_area', 'subtotal_extended', 'markup_multiplier', 'total_markup_multiplier', 'tax_id', 'tax_amount', 'total_tax_amount', 'additional_charges', 'delivery_charges', 'total_cost', 'product_charges', 'product_charges_amount', 'product_charges_total', 'fab_other', 'fab_other_amount', 'fab_other_total', 'total_quote_slab', 'total_quote_price', 'quote_total', 'wastage_amount', 'wastage_percentage', 'internal_notes'];

    protected $table = 'quote_product_price_calculators';
}
