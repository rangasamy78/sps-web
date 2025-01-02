<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotePrintedNote extends Model
{
    use HasFactory;
    protected $fillable = ['quote_printed_notes_name'];
    protected $table = 'quote_printed_notes';
}
