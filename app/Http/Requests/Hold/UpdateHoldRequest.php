<?php

namespace App\Http\Requests\Hold;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHoldRequest extends FormRequest
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
        return [
            'opportunity_id' => 'nullable|integer|exists:opportunities,id',
            'hold_code' => 'required|string|max:255',
            'hold_date' => 'required|date',
            'hold_time' => 'nullable',
            'expiry_date' => 'required|date',
            'customer_po' => 'nullable|string|max:50',
            'project_type_id' => 'nullable|integer|exists:project_types,id',
            'location_id' => 'required|integer|exists:companies,id',
            'pick_ticket_restriction' => 'required|in:Exact Slab,Within Lot,Within Product',
            'billing_customer_id' => 'required|integer|exists:customers,id',
            'bill_to_attn' => 'nullable|string|max:50',
            'bill_to_fax' => 'nullable|string|max:50',
            'bill_to_mobile' => 'nullable|string|max:50',
            'payment_term_id' => 'nullable|integer|exists:account_payment_terms,id',
            'price_level_label_id' => 'nullable|integer|exists:price_list_labels,id',
            'primary_sales_person_id' => 'required|integer|exists:users,id',
            'secondary_sales_person_id' => 'nullable|integer|exists:users,id',
            'sales_tax_id' => 'required|integer|exists:tax_codes,id',
            'hold_label' => 'nullable|string|max:255',
            'job_name' => 'nullable|string|max:250',
            'attn' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:250',
            'suite' => 'nullable|string|max:150',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'zip' => 'nullable|string|max:50',
            'country_id' => 'nullable|integer|exists:countries,id',
            'phone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50',
            'delivery_type' => 'required|in:Pick Up,Delivery',
            'how_did_hear_about_us_id' => 'required|integer|exists:about_us_options,id',
            'fabricator_id' => 'nullable|integer|exists:associates,id',
            'designer_id' => 'nullable|integer|exists:associates,id',
            'general_contractor_id' => 'nullable|integer|exists:associates,id',
            'builder_id' => 'nullable|integer|exists:associates,id',
            'brand_id' => 'nullable|integer|exists:associates,id',
            'referred_by_id' => 'nullable|integer|exists:associates,id',
            'instructions' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'printed_notes' => 'nullable|string',
            'probability_to_close_id' => 'nullable|integer|exists:probability_to_closes,id',
        ];
    }
}
