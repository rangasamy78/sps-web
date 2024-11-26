<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $fillable = [
        'visit_printed_notes',
    ];

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'id');
    }
}
