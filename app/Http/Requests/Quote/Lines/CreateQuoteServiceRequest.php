<?php

namespace App\Http\Requests\Quote\Lines;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteServiceRequest extends FormRequest
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
            'quote_id'               => 'required|integer',
            'service_id'             => 'required|integer',
            'description'            => 'nullable|string',
            'is_sold_as'             => 'nullable|boolean',
            'service_quantity'       => 'required|integer',
            'service_unit_price'     => 'required|numeric',
            'service_amount'         => 'required|numeric',
            'is_tax'                 => 'nullable|boolean',
            'is_hide_line'           => 'nullable|boolean',
        ];
    }
}
