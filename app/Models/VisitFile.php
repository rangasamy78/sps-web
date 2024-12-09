<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_type_id', 'notes', 'visit_id'];
    protected $table = 'visit_files';
}
