<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicePrice extends Model
{
    use HasFactory;

    // Specify the table if it's not the default plural form
    protected $table = 'service_price';

    // Specify the fillable fields
    protected $fillable = [
        'service_id',
        'homeowner_price',
        'bundle_price',
        'special_price',
        'loose_slab_price',
        'bundle_price_sqft',
        'special_price_per_sqft',
        'owner_approval_price',
        'loose_slab_per_slab',
        'bundle_price_per_slab',
        'special_price_per_slab',
        'owner_approval_price_per_slab',
        'price12',
        'price_range_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function price_range()
    {
        return $this->belongsTo(ProductPriceRange::class, 'price_range_id');
    }
}
