<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrderFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_type_id', 'notes', 'sales_order_id'];
    protected $table = 'sale_order_files';
}
