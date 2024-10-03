<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductKind extends Model
{
    use HasFactory;
    protected $fillable = ['product_kind_name'];
    protected $table = 'product_kinds';

    
}
