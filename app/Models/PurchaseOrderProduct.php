<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderProduct extends Model
{
    use HasFactory;
    protected $table = 'purchase_order_products';
   
    protected $fillable = [
        'po_id',
        'product_id',
        'so',
        'purchased_as',
        'description',
        'supplier_purchasng_note',
        'length',
        'width',
        'bundles',
        'slab_bundles',
        'slab',
        'quantity',
        'unit_price',
        'extended',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
        
    }
}