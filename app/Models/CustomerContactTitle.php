<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CustomerContactTitle extends Model
{
    use HasFactory;
     /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'customer_contact_titles';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'customer_title',
   ];

   protected function customerTitle(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
   }
}
