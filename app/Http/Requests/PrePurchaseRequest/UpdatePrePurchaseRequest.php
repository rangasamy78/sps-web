<?php

namespace App\Http\Requests\PrePurchaseRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePrePurchaseRequest extends FormRequest
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
            'pre_purchase_date' => 'required|date',
            'requested_by_id' => 'required|exists:users,id',
            'purchase_location_id' => 'required',
            'ship_to_location_id' => 'required',
            'conversion_rate' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'pre_purchase_date.required' => 'The pre-purchase date is required.',
            'pre_purchase_date.date' => 'The pre-purchase date must be a valid date.',
            'requested_by_id.required' => 'The requester ID is required.',
            'requested_by_id.exists' => 'The selected requester does not exist in our records.',
            'purchase_location_id.required' => 'The purchase location ID is required.',
            'purchase_location_id.exists' => 'The selected purchase location does not exist in our records.',
            'ship_to_location_id.required' => 'The ship-to location ID is required.',
            'ship_to_location_id.exists' => 'The selected ship-to location does not exist in our records.',
            'conversion_rate.required' => 'The conversion rate is required.',
            'conversion_rate.numeric' => 'The conversion rate must be a number.',
            'conversion_rate.min' => 'The conversion rate must be at least 0.',
        ];
    }
}
