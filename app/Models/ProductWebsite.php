<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWebsite extends Model
{
    use HasFactory;
    protected $table = 'product_website';
   
    protected $fillable = [
        'product_id',
        'color_enhancing',
        'countertop_vanities',
        'interior_floor',
        'fireplace_interior_wall',
        'shower_wall',
        'shower_floor',
        'exterior_floor',
        'exterior_wall',
        'pool_fountain',
        'furniture_top',
        'translucent',
        'cut_to_size',
        'sealer',
        'abrasion_resistance',
        'stain_resistance',
        'etching_resistance',
        'heat_resistance',
        'uv_resistance',
        'color_range',
        'movement_index',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
