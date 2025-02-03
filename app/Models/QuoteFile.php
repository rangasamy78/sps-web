<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteFile extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'file_type_id', 'notes', 'quote_id'];
    protected $table = 'quote_files';
}
