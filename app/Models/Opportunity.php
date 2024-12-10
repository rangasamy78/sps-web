<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opportunity extends Model
{
    use HasFactory;
    protected $table = 'opportunities';
    protected $fillable = ['opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id'];

    public function opportunity_stage()
    {
        return $this->belongsTo(OpportunityStage::class, 'opportunity_stage_id');
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
