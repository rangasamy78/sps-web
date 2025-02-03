<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotePriceCalculatorInventoryDetail extends Model
{
    use HasFactory;
    protected $fillable = ['quote_product_price_calculator_id', 'serial_number', 'lot_name', 'bundle', 'length', 'width', 'slabs', 'area', 'unit_cost', 'amount', 'notes'];
    protected $table = 'quote_price_calculator_inventory_details';
}
