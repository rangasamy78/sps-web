<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteProduct extends Model
{
    use HasFactory;

    protected $fillable = ['quote_id', 'product_id', 'description', 'is_sold_as', 'product_quantity', 'product_unit_price', 'product_amount', 'is_tax', 'is_hide_line', 'notes', 'inventory_restriction'];

    protected $table = 'quote_products';

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'id');
    }
}
