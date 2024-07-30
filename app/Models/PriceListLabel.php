<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListLabel extends Model
{
    use HasFactory;
    protected $table = 'price_list_labels';
    protected $fillable = [
        'price_level',
        'price_code',
        'price_label',
        'price_notes',
        'default_discount',
        'default_margin',
        'default_markup',
        'sales_person_commission',
    ];
    public function priceListCustomerType()
{
    return $this->hasMany(PriceListLabelCustomerType::class);
}

public function priceListLocation()
{
    return $this->hasMany(PriceListLabelLocation::class);
}
    
}
