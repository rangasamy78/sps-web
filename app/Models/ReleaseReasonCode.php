<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReleaseReasonCode extends Model
{
    use HasFactory;
    protected $table = 'release_reason_codes';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'release_reason_code'
    ];
    protected function ReleaseReasonCode(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
    }
}
