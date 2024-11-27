<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrePurchaseRequestProduct extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pre_purchase_request_products';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        's_no',
        'product_id',
        'supplier_id',
        'pre_purchase_request_id',
        'product_sku',
        'generic_name',
        'generic_sku',
        'avg_est_cost',
        'description',
        'purchasing_note',
        'pur_qty',
        'pur_uom_id',
        'length',
        'width',
        'picking_qty',
        'picking_unit',
        'slab',
        'qty',
        'response_qty',
        'unit_price',
        'total_price',
        'comments',
        'requested_product',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
