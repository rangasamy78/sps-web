<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_suppliers';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'supplier_id',
        'product_id',
        'pre_purchase_request_id',
        'product_name',
        'product_sku',
        'generic_name',
        'generic_sku',
        'requested_product',
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
        'status',
        'reject_status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
