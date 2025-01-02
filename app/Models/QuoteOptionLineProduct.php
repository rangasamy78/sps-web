<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteOptionLineProduct extends Model
{
    use HasFactory;

    protected $fillable = ['quote_product_id', 'product_id', 'description', 'is_sold_as', 'quantity', 'unit_price', 'amount'];

    protected $table = 'quote_option_line_products';
}
