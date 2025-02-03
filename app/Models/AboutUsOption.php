<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            get: fn(string $value) => ucfirst($value),
        );
    }

    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'how_did_hear_about_us_id');
    }
    public function hold()
    {
        return $this->hasMany(Hold::class, 'how_did_hear_about_us_id');
    }
}
