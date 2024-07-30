<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitMeasure extends Model
{
    use HasFactory;
    protected $table = 'unit_measures';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'unit_measure_entity',
        'unit_measure_name'
    ];
     
    protected static  $predefinedUnitMeasureOptions = [
        0 => 'Area', 
        1 => 'Count', 
        2 => 'Length', 
        3 => 'Weight',
    ];

    public static function getPredefinedUnitMeasureOptions()
    {
        return self::$predefinedUnitMeasureOptions;
    }
    
    public static function getUnitMeasureOptions($id)
    {
        switch ($id) {
            case 0:
                return 'Area';
            case 1:
                return 'Count';
            case 2:
                return 'Length';
            case 3:
                return 'Weight';   
        }
    }
    
}
