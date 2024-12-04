<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorType extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendor_types';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'vendor_type_name',
    ];

    protected function vendorTypeName(): Attribute {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    public function expenditures()
    {
        return $this->hasMany(Expenditure::class, 'expenditure_type_id', 'id');
    }

}
