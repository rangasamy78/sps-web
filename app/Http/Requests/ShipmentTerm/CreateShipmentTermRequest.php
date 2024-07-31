<?php

namespace App\Http\Requests\ShipmentTerm;

use Illuminate\Foundation\Http\FormRequest;

class CreateShipmentTermRequest extends FormRequest
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
            'shipment_term_name' => 'required|string|max:255|unique:shipment_terms,shipment_term_name',
        ];
    }
}
