<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteOptionLineService extends Model
{
    use HasFactory;

    protected $fillable = ['quote_service_id', 'service_id', 'description', 'is_sold_as', 'quantity', 'unit_price', 'amount'];

    protected $table = 'quote_option_line_services';
}
