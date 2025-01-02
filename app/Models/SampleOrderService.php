<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleOrderService extends Model
{
    use HasFactory;

    protected $fillable = ['sample_order_id', 'service_id', 'service_description', 'service_quantity', 'service_unit_price', 'service_amount', 'is_tax'];

    protected $table = 'sample_order_services';

    public function sample_order()
    {
        return $this->belongsTo(SampleOrder::class, 'sample_order_id');
    }
}
