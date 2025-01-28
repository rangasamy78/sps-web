<?php

namespace App\Http\Requests\QuoteFooter;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteFooterRequest extends FormRequest
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
            'quote_footer_name' => 'required|string|max:255|unique:quote_footers,quote_footer_name',
        ];
    }
}
