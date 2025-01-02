<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceRange extends Model
{
    use HasFactory;
    protected $table = 'product_price_ranges';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_price_range',
    ];

    public function product_price()
    {
        return $this->hasMany(ProductPrice::class, 'price_range_id');
    }
    public function service_price()
    {
        return $this->hasMany(ServicePrice::class, 'price_range_id');
    }
}
