<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    use HasFactory;
    protected $table = 'associates';

    protected $fillable = [
        'associate_name',
        'associate_code',
        'associate_type_id',
        'contact_name',
        'referred_by',
        'location_id',
        'route_id',
        'primary_sales_id',
        'secondary_sales_id',
        'internal_notes',
        'primary_phone',
        'secondary_phone',
        'mobile',
        'fax',
        'email',
        'accounting_email',
        'website',
        'address',
        'suite',
        'city',
        'state',
        'zip',
        'country_id',
        'status',
    ];

    
    public function associate_type()
    {
        return $this->belongsTo(CustomerType::class);
    }
    
    public function location()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'primary_sales_id');
    }
}


