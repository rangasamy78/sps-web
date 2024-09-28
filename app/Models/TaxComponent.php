<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxComponent extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_components';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'sort_order',
        'component_name',
        'component_tax_id',
        'authority_id',
        'sales_tax_id',
    ];

    protected function componentName(): Attribute {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    public function tax_authority()
    {
        return $this->belongsTo(TaxAuthority::class, 'authority_id', 'id');
    }
}
