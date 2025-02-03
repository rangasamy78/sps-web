<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function opportunity_fabricator()
    {
        return $this->hasMany(Opportunity::class, 'fabricator_id');
    }
    public function opportunity_designer()
    {
        return $this->hasMany(Opportunity::class, 'designer_id');
    }
    public function opportunity_builder()
    {
        return $this->hasMany(Opportunity::class, 'builder_id');
    }
    public function hold_fabricator()
    {
        return $this->hasMany(Hold::class, 'fabricator_id');
    }
    public function hold_designer()
    {
        return $this->hasMany(Hold::class, 'designer_id');
    }
    public function hold_builder()
    {
        return $this->hasMany(Hold::class, 'builder_id');
    }
    public function hold_brand()
    {
        return $this->hasMany(Hold::class, 'brand_id');
    }
    public function hold_general_contractor()
    {
        return $this->hasMany(Hold::class, 'general_contractor_id');
    }
    public function hold_referred_by()
    {
        return $this->hasMany(Hold::class, 'referred_by_id');
    }
}
