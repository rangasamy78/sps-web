<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = ['opportunity', 'date', 'end_use_segment_id', 'project_type_id', 'stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'delivery_end_customer', 'delivery_attn', 'delivery_ship_to', 'delivery_ship_to_name', 'delivery_address', 'delivery_suite', 'delivery_city', 'delivery_state', 'delivery_zip', 'delivery_county_id', 'delivery_country_id', 'delivery_phone', 'delivery_fax', 'delivery_mobile', 'delivery_lot', 'delivery_sub_division', 'delivery_email', 'delivery_how_did_hear_about_us_id', 'delivery_is_do_not_send_email', 'pick_end_customer', 'pick_attn', 'pick_phone', 'pick_mobile', 'pick_lot', 'pick_sub_division', 'pick_email', 'pick_how_did_hear_about_us_id', 'pick_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id'];

    protected $table = 'opportunities';
}
