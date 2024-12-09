<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = ['opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id'];

    protected $table = 'opportunities';

    public function primary_user()
    {
        return $this->belongsTo(User::class, 'primary_sales_person_id');
    }
    public function secondary_user()
    {
        return $this->belongsTo(User::class, 'secondary_sales_person_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'billing_customer_id');
    }
    public function end_use_segment()
    {
        return $this->belongsTo(EndUseSegment::class, 'end_use_segment_id');
    }
    public function project_type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    public function location()
    {
        return $this->belongsTo(Company::class, 'location_id');
    }
    public function price_list()
    {
        return $this->belongsTo(PriceListLabel::class, 'price_level_label_id');
    }
    public function sales_tax()
    {
        return $this->belongsTo(TaxCode::class, 'sales_tax_id');
    }
    public function visit()
    {
        return $this->hasMany(Visit::class, 'opportunity_id');
    }
    public function how_did_you_hear()
    {
        return $this->belongsTo(AboutUsOption::class, 'how_did_hear_about_us_id');
    }
    public function fabricator()
    {
        return $this->belongsTo(Associate::class, 'fabricator_id');
    }
    public function designer()
    {
        return $this->belongsTo(Associate::class, 'designer_id');
    }
    public function builder()
    {
        return $this->belongsTo(Associate::class, 'builder_id');
    }
}
