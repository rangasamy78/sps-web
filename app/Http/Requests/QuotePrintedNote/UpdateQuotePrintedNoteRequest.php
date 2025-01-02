<?php

namespace App\Http\Requests\QuotePrintedNote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuotePrintedNoteRequest extends FormRequest
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
            'quote_printed_notes_name' => 'required|string|unique:quote_printed_notes,quote_printed_notes_name,' . $this->route('quote_printed_note')->id
        ];
    }
}
