<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnReasonCode extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'return_reason_codes';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'return_code'
   ];

   protected function returnCode(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
   }
}
