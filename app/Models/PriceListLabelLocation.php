<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListLabelLocation extends Model
{
    use HasFactory;
    protected $table = 'price_list_label_locations';
    protected $fillable = [
        'price_list_label_id',
        'location_id',
    ];
    public function location()
    {
        return $this->belongsTo(PriceListLabel::class, 'price_list_label_id');
    }
}
