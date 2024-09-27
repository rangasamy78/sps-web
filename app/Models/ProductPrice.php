<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    // Specify the table if it's not the default plural form
    protected $table = 'product_price';

    // Specify the fillable fields
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
        'price_range',
    ];

    // Define the relationship to the Product model (assuming a Product model exists)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
