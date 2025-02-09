<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['opportunity_id', 'visit_label', 'visit_date', 'visit_time', 'sales_person_id', 'price_level_id', 'end_use_segment_id', 'project_type_id', 'visit_printed_notes', 'visit_internal_notes',  'probability_close_id', 'survey_rating', 'checkout', 'total'];

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
    public function end_use_segments()
    {
        return $this->belongsTo(EndUseSegment::class, 'end_use_segment_id', 'id');
    }
    public function project_type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id', 'id');
    }
}
