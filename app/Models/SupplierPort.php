<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPort extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplier_ports';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'supplier_port_name',
        'avg_days',
        'country_id',
    ];

    protected function supplierPortName(): Attribute {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
