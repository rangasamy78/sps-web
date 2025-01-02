<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleOrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['sample_order_id', 'product_id', 'product_quantity', 'sample_quantity', 'product_unit_price', 'product_amount', 'is_sold_as', 'is_tax', 'product_description'];

    protected $table = 'sample_order_products';
    public function sample_order()
    {
        return $this->belongsTo(SampleOrder::class, 'sample_order_id');
    }
}
