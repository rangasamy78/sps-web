<?php

namespace App\Http\Requests\QuoteHeader;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteHeaderRequest extends FormRequest
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
            'quote_header_name' => 'required|string|max:255|unique:quote_headers,quote_header_name',
        ];

    }
}
