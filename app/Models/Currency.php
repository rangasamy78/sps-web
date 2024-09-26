<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'currency_code', 'currency_name', 'currency_symbol', 'currency_exchange_rate'];
    protected $table = 'currencies';

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'currency_id');
    }
}
