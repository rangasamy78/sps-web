<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldProduct extends Model
{
    use HasFactory;

    protected $fillable = ['hold_id', 'product_id', 'product_quantity', 'sample_quantity', 'product_unit_price', 'product_amount', 'is_sold_as', 'is_tax', 'product_description'];

    protected $table = 'hold_products';

    public function hold()
    {
        return $this->belongsTo(Hold::class, 'hold_id');
    }
}
