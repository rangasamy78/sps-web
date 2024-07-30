<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubHeading extends Model
{
    use HasFactory;
    protected $table = 'sub_headings';
    protected $fillable = [
        'sub_heading_name',
    ];
    
   protected function subHeadingName(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
   }
}
