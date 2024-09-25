<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
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
    protected $table = 'contacts';
}
