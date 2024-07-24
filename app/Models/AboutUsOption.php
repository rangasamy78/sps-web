<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AboutUsOption extends Model
{
    use HasFactory;
    protected $table = 'about_us_options';
    protected $fillable = [
        'how_did_you_hear_option',
    ];
    protected function howDidYouHearOption(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }
}
