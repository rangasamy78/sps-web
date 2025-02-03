<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldService extends Model
{
    use HasFactory;
    protected $fillable = ['hold_id', 'service_id', 'service_description', 'service_quantity', 'service_unit_price', 'service_amount', 'is_tax'];

    protected $table = 'hold_services';

    public function hold()
    {
        return $this->belongsTo(Hold::class, 'hold_id');
    }
}
