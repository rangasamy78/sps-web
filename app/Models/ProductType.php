<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $table = 'product_types';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'product_type',
        'indivisible',
        'non_serialized',
        'inventory_gl_account',
        'sales_gl_account',
        'cogs_gl_account'
    ];
}
