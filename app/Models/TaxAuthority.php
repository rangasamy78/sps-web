<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxAuthority extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_authorities';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'authority_name',
        'print_name',
        'authority_code',
        'contact_name',
        'primary_phone',
        'secondary_phone',
        'mobile',
        'fax',
        'email',
        'website',
        'address',
        'suite',
        'city',
        'state',
        'zip',
        'country_id',
        'tax_number',
        'check_memo',
        'internal_notes',
    ];

    protected function authorityName(): Attribute {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

}
