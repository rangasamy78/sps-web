<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = ['opportunity_id', 'quote_label', 'quote_date', 'quote_time', 'expiry_date', 'customer_po', 'price_level_id', 'end_use_segment_id', 'project_type_id', 'eta_date', 'payment_terms_id', 'sales_tax_id', 'secondary_sales_person_id', 'quote_header_id', 'quote_footer_id', 'quote_printed_notes_id', 'quote_printed_note', 'quote_internal_note', 'probability_close_id', 'survey_rating', 'total', 'status_update_date', 'status_update_user_id', 'notes', 'status'];
    protected $table = 'quotes';

    public function sales_tax()
    {
        return $this->belongsTo(TaxCode::class, 'sales_tax_id');
    }
    public function price_list()
    {
        return $this->belongsTo(PriceListLabel::class, 'price_level_id');
    }
    public function payment_term()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_terms_id', 'id');
    }
    public function opportunities()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
    }
    public function project_type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id', 'id');
    }
    public function probability_close()
    {
        return $this->belongsTo(ProbabilityToClose::class, 'probability_close_id', 'id');
    }
    public function quote_product()
    {
        return $this->hasMany(QuoteProduct::class, 'quote_id', 'id');
    }
    public function quote_service()
    {
        return $this->hasMany(QuoteService::class, 'quote_id', 'id');
    }
    public function end_use_segments()
    {
        return $this->belongsTo(EndUseSegment::class, 'end_use_segment_id', 'id');
    }
}
