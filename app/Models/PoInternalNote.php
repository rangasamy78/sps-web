<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoInternalNote extends Model
{
    use HasFactory;
    protected $table = 'po_internal_notes';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'po_internal_notes',
        'purchase_order_id',
       
    ];
}
