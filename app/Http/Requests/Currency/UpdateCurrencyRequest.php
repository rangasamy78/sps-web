<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
        $currencyId = $this->currency ? $this->currency->id : null;

        return [
            'currency_code' => 'required|string|max:255|unique:currencies,currency_code,' . $currencyId,
            'currency_name' => 'required|string|max:255|unique:currencies,currency_name,' . $currencyId,
            'currency_symbol' => 'required|string|max:255',
            'currency_exchange_rate' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'currency_code.required' => 'Currency code is required.',
            'currency_code.string' => 'Currency code must be a string.',
            'currency_code.max' => 'Currency code must not exceed 255 characters.',
            'currency_code.unique' => 'Currency code must be unique.',

            'currency_name.required' => 'Currency name is required.',
            'currency_name.string' => 'Currency name must be a string.',
            'currency_name.max' => 'Currency name must not exceed 255 characters.',
            'currency_name.unique' => 'Currency name must be unique.',

            'currency_symbol.required' => 'Currency symbol is required.',
            'currency_symbol.string' => 'Currency symbol must be a string.',
            'currency_symbol.max' => 'Currency symbol must not exceed 255 characters.',

            'currency_exchange_rate.required' => 'Currency exchange rate is required.',
            'currency_exchange_rate.integer' => 'Currency exchange rate must be an integer.',
        ];
    }
}
