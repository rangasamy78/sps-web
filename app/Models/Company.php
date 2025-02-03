<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    public const IMAGE_FOLDER = 'company';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'email',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'phone_1',
        'phone_2',
        'website',
        'logo',
        'is_bin_pre_defined',
    ];

    protected function companyName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }
    public function account()
    {
        return $this->hasMany(Account::class, 'account_operating_location_id');
    }

    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'location_id');
    }
    public function hold()
    {
        return $this->hasMany(Opportunity::class, 'location_id');
    }
}
