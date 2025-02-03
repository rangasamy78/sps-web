<?php

namespace App\Http\Requests\SaleOrder;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $sales_orderId = optional($this->route('sale_order'))->id; // Handle case when route param might be null
        return [
            'sales_order_code' => 'required|string|unique:sale_orders,sales_order_code,' . $sales_orderId,
            'sales_order_date' => 'required|string|max:255',
            'location_id' => 'required|integer|exists:companies,id',
            'payment_term_id' => 'required|integer|exists:account_payment_terms,id',
            // 'end_use_segment_id' => 'nullable|integer|exists:end_use_segments,id',
            // 'project_type_id' => 'nullable|integer|exists:project_types,id',
            // 'opportunity_stage_id' => 'nullable|integer|exists:opportunity_stages,id',
            // 'contact_mode' => 'nullable|string|max:50',
            'billing_customer_id' => 'required|integer|exists:customers,id',
            'attn' => 'nullable|string|max:100',
            'price_level_label_id' => 'nullable|integer|exists:price_list_label_locations,id',
            'primary_sales_person_id' => 'required|integer|exists:users,id',
            'secondary_sales_person_id' => 'nullable|integer|exists:users,id',
            // 'total_value' => 'nullable|numeric|min:0',
            'sales_tax_id' => 'nullable|integer|exists:tax_codes,id',

            // Delivery Information
            'ship_to_type' => 'required|string', // Ensure ship_to_type is required

            // Conditional fields based on ship_to_type
            'ship_to_job_name' => 'nullable|string|max:255',
            'ship_to_attn' => 'nullable|string|max:100',
            'ship_to_id' => 'nullable|string|max:255',
            'ship_to_name' => 'nullable|string|max:255',
            'ship_to_address' => 'nullable|string|max:255',
            'ship_to_suite' => 'nullable|string|max:50',
            'ship_to_city' => 'nullable|string|max:100',
            'ship_to_state' => 'nullable|string|max:100',

            // Delivery-specific validation for "Delivery" method
            'ship_to_zip' => Rule::requiredIf(function () {
                return request('ship_to_type') === 'Delivery'; // Only required if ship_to_type is "Delivery"
            }),

            'ship_to_county_id' => 'nullable|integer|exists:counties,id',
            'ship_to_country_id' => 'nullable|integer|exists:countries,id',
            'ship_to_phone' => 'nullable|string|max:20',
            'ship_to_fax' => 'nullable|string|max:20',
            'ship_to_mobile' => 'nullable|string|max:20',
            'delivery_lot' => 'nullable|string|max:50',
            'ship_to_sub_division' => 'nullable|string|max:50',
            'ship_to_email' => 'nullable|email|max:100',
            'is_cod' => 'nullable|boolean',
            // 'how_did_hear_about_us_id' => Rule::requiredIf(function () {
            //     return request('ship_to_type') === 'Delivery'; // Only required if ship_to_type is "Delivery"
            // }),
            // 'is_do_not_send_email' => 'nullable|boolean',
            // Other fields
            'fabricator_id' => 'nullable|integer|exists:associates,id',
            'designer_id' => 'nullable|integer|exists:associates,id',
            'builder_id' => 'nullable|integer|exists:associates,id',
            'special_instructions' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'printed_notes' => 'nullable|string',
            'survey_rating_notes' => 'nullable|string',
            // 'probability_to_close_id' => 'nullable|integer',
            'freight_carrier_id' => 'nullable|integer',
            'route_id' => 'nullable|integer',
            'shipping_tracking_number' => 'nullable|string',
            'print_doc_disclaimer_id' => 'nullable|integer',
            'print_doc_description_editor' => 'nullable|string',
            'requested_ship_date' => 'nullable|string',
            'est_delivery_date' => 'nullable|string',
            'entered_by_id' => 'required|integer|exists:users,id',
        ];
    }
}
