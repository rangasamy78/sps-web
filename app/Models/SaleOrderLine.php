<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrderLine extends Model
{

    use HasFactory;

    protected $fillable = ['sales_order_id', 'item_id', 'so_line_no', 'item_description', 'quantity', 'unit_price', 'extended_amount', 'is_taxable', 'is_sold_as', 'is_hideon_print', 'line_item', 'is_not_in_stock', 'supplier_description', 'pick_ticket_restriction'];

    protected $table = 'sale_order_lines';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (!$data->so_line_no) {
                $maxListId = SaleOrderLine::where('sales_order_id', $data->sales_order_id)->max('so_line_no');
                $data->so_line_no = $maxListId ? $maxListId + 10 : 10;
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'item_id');
    }
    // public function unit_measures()
    // {
    //     return $this->belongsTo(UnitMeasure::class, 'item_id');
    // }
    public function unit_measures_so()
    {
        return $this->belongsTo(Service::class, 'item_id');
    }
}


