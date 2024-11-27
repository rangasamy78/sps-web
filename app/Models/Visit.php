<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['opportunity_id', 'visit_label', 'visit_date', 'visit_time', 'sales_person_id', 'price_level_id', 'visit_printed_notes',  'probability_close_id', 'survey_rating', 'checkout'];

    protected $table = 'visits';

    public function products()
    {
        return $this->hasMany(VisitProduct::class);
    }

    public function services()
    {
        return $this->hasMany(VisitService::class);
    }
    public function opportunities()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id');
    }
}
