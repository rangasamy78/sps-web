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
    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'price_level_label_id');
    }
    public function quote()
    {
        return $this->hasMany(Quote::class, 'price_level_id');
    }
    public function hold()
    {
        return $this->hasMany(Hold::class, 'price_level_id');
    }
}
