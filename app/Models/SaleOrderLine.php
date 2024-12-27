<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrderLine extends Model
{
    use HasFactory;

    protected $fillable = ['so_line_number'];
    protected $table = 'sale_order_lines';
}
