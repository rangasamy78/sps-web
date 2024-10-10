<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateFile extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'notes', 'associate_id'];
    protected $table = 'associate_files';
}
