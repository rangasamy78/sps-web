<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherCharges extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_id',
        'service_id',
        'account_id',
        'description',
        'extended',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
        
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
        
    }
}

