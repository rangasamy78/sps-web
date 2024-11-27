<?php

namespace App\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;

class CreateVisitRequest extends FormRequest
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
            'visit_label' => 'nullable|string',
            'visit_date' => 'required|date',
            'visit_time' => 'nullable|date_format:H:i', // Use `date_format` for specific time formats
            'sales_person_id' => 'nullable|integer',
            'price_level_id' => 'nullable|integer',
            'visit_printed_notes' => 'nullable|string', // Use boolean if true/false
            'probability_close_id' => 'nullable|integer',
            'survey_rating' => 'nullable|string|max:255', // Adding max length for consistency
            'checkout' => 'nullable|numeric', // For decimal or numeric values
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
}
