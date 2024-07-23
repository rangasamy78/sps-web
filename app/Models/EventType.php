<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventType extends Model
{
    use HasFactory;


     /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'event_types';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'event_type_name',
       'event_type_code',
       'event_category_id'
   ];

   protected function eventTypeName(): Attribute
   {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
   }

     protected static $eventCategory = [
        0 => 'Task',
        1 => 'Event',
        2 => 'Note',
        3 => 'Call',
        4 => 'Visit',
    ];

    public static function getEventCategory()
    {
        return self::$eventCategory;
    }
}
