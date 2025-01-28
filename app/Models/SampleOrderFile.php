<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleOrderFile extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'file_type_id', 'notes', 'sample_order_id'];
    protected $table = 'sample_order_files';
}
