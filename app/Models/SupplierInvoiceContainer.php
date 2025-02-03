<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoiceContainer extends Model
{
    use HasFactory;
    protected $fillable = ['container_number', 'received_on', 'received_on', 'received_by', 'notes','po_id'];
    protected $table = 'supplier_invoice_containers';
}
