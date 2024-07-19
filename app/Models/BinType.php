<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinType extends Model
{
    use HasFactory;
    protected $table = 'bin_types';
    protected $fillable = [
        'id',
        'bin_type',
    ];
    //custom timestamps name
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
