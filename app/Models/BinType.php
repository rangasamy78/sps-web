<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BinType extends Model
{
    use HasFactory;
    protected $table = 'bin_types';
    protected $fillable = [
        'id',
        'bin_type',
    ];
    protected function binType(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }
}
