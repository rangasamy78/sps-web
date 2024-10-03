<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    protected $table = 'product_price';
    protected $fillable = [
        'product_id',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
