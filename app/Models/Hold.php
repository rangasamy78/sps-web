<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    use HasFactory;
    protected $fillable = ['opportunity_id', 'hold_code', 'hold_date', 'hold_time', 'expiry_date', 'customer_po', 'project_type_id', 'location_id', 'pick_ticket_restriction', 'billing_customer_id', 'bill_to_attn', 'bill_to_fax', 'bill_to_mobile', 'payment_term_id', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'sales_tax_id', 'hold_label', 'job_name', 'attn', 'address', 'suite', 'city', 'state', 'zip', 'country_id', 'phone', 'fax', 'mobile', 'email', 'delivery_type_id', 'how_did_hear_about_us_id', 'fabricator_id', 'designer_id', 'general_contractor_id', 'builder_id', 'brand_id', 'referred_by_id', 'instructions', 'internal_notes', 'printed_notes', 'probability_to_close_id', 'survey_rating', 'release_date', 'release_hold_reason', 'is_released', 'total'];
    protected $table = 'holds';

    public function opportunities()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id');
    }
    public function location()
    {
        return $this->belongsTo(Company::class, 'location_id');
    }
    public function payment_term()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_term_id');
    }
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
    public function price_list()
    {
        return $this->belongsTo(PriceListLabel::class, 'price_level_label_id');
    }
    public function sales_tax()
    {
        return $this->belongsTo(TaxCode::class, 'sales_tax_id');
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
    public function general_contractor()
    {
        return $this->belongsTo(Associate::class, 'general_contractor_id');
    }
    public function brand()
    {
        return $this->belongsTo(Associate::class, 'brand_id');
    }
    public function referred_by()
    {
        return $this->belongsTo(Associate::class, 'referred_by_id');
    }

    public function how_did_you_hear()
    {
        return $this->belongsTo(AboutUsOption::class, 'how_did_hear_about_us_id');
    }
    public function project_type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function hold_products()
    {
        return $this->hasMany(HoldProduct::class, 'hold_id');
    }
    public function hold_services()
    {
        return $this->hasMany(HoldService::class, 'hold_id');
    }
}
