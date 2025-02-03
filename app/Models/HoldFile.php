<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldFile extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'file_type_id', 'notes', 'hold_id'];
    protected $table = 'hold_files';

    
}
