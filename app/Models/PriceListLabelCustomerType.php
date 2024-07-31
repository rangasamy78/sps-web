<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PriceListLabelCustomerType extends Model
{
    use HasFactory;
    protected $table = 'price_list_label_customer_types';
    protected $fillable = [
        'price_list_label_id',
        'customer_type_id',
    ];

    public function customerType()
    {
        return $this->belongsTo(PriceListLabel::class, 'price_list_label_id');
    }
}
