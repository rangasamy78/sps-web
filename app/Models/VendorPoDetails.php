<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPoDetails extends Model
{
    use HasFactory;
    protected $table    = 'vendor_po_details';
    protected $fillable = [
        'vendor_po_id',
        'service',
        'purchase_check',
        'purchase',
        'description',
        'alt_qty',
        'alt_uom',
        'alt_ucost',
        'quantity',
        'uom',
        'unit_cost',
        'extended',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service');
    }
}