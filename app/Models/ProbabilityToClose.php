<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProbabilityToClose extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'probability_to_closes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'probability_to_close'
    ];

    protected function probabilityToClose(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }

    public function Probability()
    {
        return $this->hasMany(Opportunity::class, 'probability_to_close_id');
    }
    public function quote()
    {
        return $this->hasMany(Quote::class, 'probability_close_id', 'id');
    }
}
