<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class QuoteHeader extends Model
{
    use HasFactory;

    protected $fillable = ['quote_header_name'];
    protected $table = 'quote_headers';
}
