<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SupplierCostListLabel extends Model
{
    use HasFactory;
    protected $table = 'supplier_cost_list_labels';
    protected $fillable = [
        'cost_level',
        'cost_code',
        'cost_label',
    ];
    protected function costLevel(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }
}
