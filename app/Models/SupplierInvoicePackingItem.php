<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoicePackingItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplier_invoice_packing_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'po_id',
        'bar_code_no',
        'seq_no',
        'packing_list_sizes',
        'received_sizes',
        'unit_type_name',
        'unit_pack_length',
        'unit_pack_width',
        'pack_length',
        'pack_width',
        'rec_length',
        'rec_width',
        'transaction_no',
        'serial_no',
        'lot_block',
        'bundle',
        'supplier_ref',
        'bin_type_id',
        'bin_type_name',
        'present_location',
        'notes',
        'count',
        'isSeqBlock',
        'isSeqBundle',
        'isSeqSupplier',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}