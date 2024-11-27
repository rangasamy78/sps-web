<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPoFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'notes', 'vendor_po_id'];
    protected $table = 'vendor_po_files';
}