<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteService extends Model
{
    use HasFactory;

    protected $fillable = ['quote_id', 'service_id', 'description', 'is_sold_as', 'service_quantity', 'service_unit_price', 'service_amount', 'is_tax', 'is_hide_line'];
    protected $table = 'quote_services';

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
