<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opportunity extends Model
{
    use HasFactory;
    protected $table = 'opportunities';
    protected $fillable = [
        'internal_notes',
    ];
    public function opportunity_stages()
    {
        return $this->belongsTo(OpportunityStage::class, 'id');
    }

    public function probability_to_closes()
    {
        return $this->belongsTo(ProbabilityToClose::class, 'id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'opportunity_id');
    }
}
