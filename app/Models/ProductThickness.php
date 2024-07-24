<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProductThickness extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'product_thicknesses';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'product_thickness_name',
       'product_thickness_unit',
   ];
   protected function ProductThickness(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
    }
}
