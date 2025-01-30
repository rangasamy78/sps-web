<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = ['consignment_date', 'consignment_location_id', 'consignment_type'];
    protected $table = 'consignments';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'consignment_location_id', 'id');
    }
}
