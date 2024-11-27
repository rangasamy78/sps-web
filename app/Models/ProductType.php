<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'inventory_gl_account_id',
        'sales_gl_account_id',
        'cogs_gl_account_id'
    ];

    function linked_account_inventory_gl()
    {
        return $this->belongsTo(LinkedAccount::class, 'inventory_gl_account_id');
    }

    function linked_account_sales_gl()
    {
        return $this->belongsTo(LinkedAccount::class, 'sales_gl_account_id');
    }

    function linked_account_cogs_gl()
    {
        return $this->belongsTo(LinkedAccount::class, 'cogs_gl_account_id');
    }

    function product()
    {
        return $this->HasMany(Product::class, 'product_type_id');
    }
}
