<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'contact_name',
        'title',
        'type',
        'type_id',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        'county_id',
        'lot',
        'sub_division',
        'country_id',
        'primary_phone',
        'secondary_phone',
        'mobile',
        'fax',
        'email',
        'is_ship_to_address',
        'tax_code_id',
        'internal_notes',
    ];

    public $table = 'contacts';

    const CUSTOMER    = 'customer';
    const SUPPLIER    = 'supplier';
    const EXPENDITURE = 'expenditure';
    const ASSOCIATE   = 'associate';

    public function scopeOfType(Builder $query, $typeId, $type)
    {
        return $query->where('type_id', $typeId)
            ->where('type', $type);
    }

}
