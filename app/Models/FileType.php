<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileType extends Model
{
    use HasFactory;
    protected $table = 'file_types';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'id',
        'view_in',
        'file_type',
        'file_type_opportunity',
        'file_type_quote',
        'file_type_saleorder',
        'file_type_invoice'
        
    ];

    protected static $predefinedViewInOptions = [
        1 => 'Item',
        2 => 'Party',
        3 => 'Transaction'
    ];

    public static function predefinedViewInOptions()
    {
        return self::$predefinedViewInOptions;
    }
}
