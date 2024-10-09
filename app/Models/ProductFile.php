<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'notes', 'product_id'];
    protected $table = 'product_files';
}
