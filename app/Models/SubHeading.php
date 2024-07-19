<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHeading extends Model
{
    use HasFactory;

    protected $table = 'sub_headings';

    protected $fillable = [
        'sub_heading_name',
        'set_as_default',
        
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
