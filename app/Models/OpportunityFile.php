<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_type_id', 'notes', 'opportunity_id'];
    protected $table = 'opportunity_files';
}
