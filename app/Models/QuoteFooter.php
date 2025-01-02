<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteFooter extends Model
{
    use HasFactory;

    protected $fillable = ['quote_footer_name'];
    protected $table = 'quote_footers';
}
