<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'code',
        'department_id',
        'designation_id',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtolower($value),
        );
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'primary_sales_person_id');
    }
    public function opportunitySecondary()
    {
        return $this->hasMany(Opportunity::class, 'secondary_sales_person_id');
    }
    public function event()
    {
        return $this->hasMany(Event::class, 'entered_by_id');
    }
    public function eventAssignedTo()
    {
        return $this->hasMany(Event::class, 'assigned_to_id');
    }
    public function hold_primary()
    {
        return $this->hasMany(Hold::class, 'primary_sales_person_id');
    }
    public function hold_secondary()
    {
        return $this->hasMany(Hold::class, 'secondary_sales_person_id');
    }
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
