<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFinish extends Model
{
    use HasFactory;
    protected $table = 'product_finishes';
    protected $fillable = [
        'product_finish_code',
        'finish'
    ];

}
