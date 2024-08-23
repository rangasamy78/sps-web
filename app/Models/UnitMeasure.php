<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        1 => 'Area', 
        2 => 'Count', 
        3 => 'Length', 
        4 => 'Weight',
    ];

    public static function getPredefinedUnitMeasureOptions()
    {
        return self::$predefinedUnitMeasureOptions;
    }
    
    public static function getUnitMeasureOptions($id)
    {
        switch ($id) {
            case 1:
                return 'Area';
            case 2:
                return 'Count';
            case 3:
                return 'Length';
            case 4:
                return 'Weight';   
        }
    }
    
}
