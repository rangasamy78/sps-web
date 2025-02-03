<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrder extends Model
{
    use HasFactory;

    protected $fillable = ['sales_order_code', 'sales_order_date', 'customer_po_code', 'location_id', 'billing_customer_id', 'attn', 'payment_term_id', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'is_cod', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'requested_ship_date', 'est_delivery_date', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'commission_amount', 'commission_notes', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'freight_carrier_id', 'route_id', 'shipping_tracking_number', 'print_doc_disclaimer_id', 'print_doc_description_editor', 'entered_by_id'];

    protected $table = 'sale_orders';

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
}
