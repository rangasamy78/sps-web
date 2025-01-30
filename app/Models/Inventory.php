<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'sipl_id',
        'product_id',
        'inventory_in_stock',
        'inventory_committed',
        'inventory_available',
        'received_date',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function supplier_inv_packing()
    {
        return $this->belongsTo(SupplierInvoicePackingItem::class, 'product_id', 'product_id');
    }
}
