<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitProduct extends Model
{
    use HasFactory;
    protected $fillable = ['visit_id', 'product_id', 'product_quantity', 'product_unit_price', 'product_amount', 'is_sold_as', 'is_tax', 'product_description'];

    protected $table = 'visit_products';

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
    public function product_23()
    {
        dd('asdasfdsa');
        $a = $this->belongsTo(Product::class, 'product_id');
    }
    public function product_price()
    {
        return $this->hasOne(ProductPrice::class);
    }
}
