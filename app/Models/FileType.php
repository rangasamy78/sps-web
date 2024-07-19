<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function predefinedViewInOptions()
    {
        return ['Item', 'Party', 'Transaction'];
    }

    
}
