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
            get: fn(string $value) => ucfirst($value),
        );
    }

    protected static $eventCategory = [
        1 => 'Task',
        2 => 'Event',
        3 => 'Note',
        4 => 'Call',
        5 => 'Visit',
    ];

    public static function getEventCategory()
    {
        return self::$eventCategory;
    }
    public function event()
    {
        return $this->hasMany(Event::class, 'event_type_id');
    }
}
