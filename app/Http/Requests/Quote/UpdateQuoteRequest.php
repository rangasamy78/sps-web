<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
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
            'opportunity_id' => 'required|integer|exists:opportunities,id',
            'quote_label' => 'nullable|string|max:255',
            'quote_date' => 'required|date',
            'quote_time' => 'nullable',
            'expiry_date' => 'required|date',
            'customer_po' => 'nullable|string|max:100',
            'price_level_id' => 'required|integer|exists:price_list_labels,id',
            'end_use_segment_id' => 'nullable|integer|exists:end_use_segments,id',
            'project_type_id' => 'nullable|integer|exists:product_types,id',
            'eta_date' => 'nullable|date',
            'payment_terms_id' => 'required|integer|exists:account_payment_terms,id',
            'sales_tax_id' => 'required|integer|exists:tax_codes,id',
            'secondary_sales_person_id' => 'nullable|integer|exists:users,id',
            'quote_header_id' => 'nullable|integer|exists:quote_headers,id',
            'quote_footer_id' => 'nullable|integer|exists:quote_footers,id',
            'quote_printed_notes_id' => 'nullable|integer|exists:quote_printed_notes,id',
            'quote_printed_note' => 'nullable|string|max:500',
            'quote_internal_note' => 'nullable|string|max:1000',
            'probability_close_id' => 'nullable|integer|exists:probability_to_closes,id',
            'survey_rating' => 'nullable|string',
            'total' => 'nullable|numeric',
            'status_update_date' => 'required',
            'status_update_user_id' => 'required|numeric',
            'notes' => 'nullable',
            'status' => 'required',
        ];
    }
}
