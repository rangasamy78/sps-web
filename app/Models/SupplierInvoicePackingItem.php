<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    protected $_fillable = [
        'po_product_id',
        'product_id',
        'po_id',
        'sipl_id',
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

    function product_item()
    {
        return $this->belongsTo(Product::class, 'id');
    }        

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'ship_location_id', 'id');
    }


    public function updateNoteItem($data)
    {
        return $this->update(['notes' => $data['note']]);
    }
}
