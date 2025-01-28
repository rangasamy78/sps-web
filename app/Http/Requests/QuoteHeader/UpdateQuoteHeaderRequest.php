<?php

namespace App\Http\Requests\QuoteHeader;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteHeaderRequest extends FormRequest
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
            'quote_header_name' => 'required|string|unique:quote_headers,quote_header_name,' . $this->route('quote_header')->id
        ];
    }
}
