<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoiceFile extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'notes', 'po_id'];
    protected $table = 'supplier_invoice_files';
}
