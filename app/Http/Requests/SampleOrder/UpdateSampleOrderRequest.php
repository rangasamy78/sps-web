<?php

namespace App\Http\Requests\SampleOrder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSampleOrderRequest extends FormRequest
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
            'opportunity_id' => 'required|integer',
            'sample_order_label' => 'nullable|string|max:255',
            'sample_order_date' => 'required|date|before_or_equal:today', // Ensures date is valid and not in the future
            'sample_order_time' => 'nullable', // 12-hour time format with AM/PM
            'sales_person_id' => 'nullable|integer',
            'delivery_type' => 'nullable|string|max:255',
            'delivery_attn' => 'nullable|string|max:50',
            'delivery_tracking' => 'nullable|string|max:50',
            'delivery_address' => 'nullable|string|max:250',
            'delivery_suite' => 'nullable|string|max:150',
            'delivery_city' => 'nullable|string|max:100',
            'delivery_state' => 'nullable|string|max:100',
            'delivery_zip' => 'nullable|string|max:20|regex:/^\d{4,10}$/', // Optional: Validate ZIP codes
            'delivery_country_id' => 'nullable|integer|exists:countries,id', // Ensures the country ID exists in the countries table
            'document_footer_id' => 'nullable|integer|exists:print_doc_disclaimers,id', // Validate foreign key
            'sample_order_printed_notes' => 'nullable|string|max:500', // Set reasonable max length
            'probability_close_id' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'total' => 'nullable|numeric|min:0', // Ensure total is non-negative
        ];
    }
}
