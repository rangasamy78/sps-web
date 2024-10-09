<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_type_id', 'notes', 'supplier_id'];
    protected $table = 'supplier_files';
}
