<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitService extends Model
{
    use HasFactory;
    protected $fillable = ['visit_id', 'service_id', 'service_description', 'service_quantity', 'service_unit_price', 'service_amount', 'is_tax'];

    protected $table = 'visit_services';

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
    
}
