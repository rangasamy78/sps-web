<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentMethod extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'shipment_methods';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'shipment_method_name',
   ];

   protected function shipmentMethodName(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
   }
}
