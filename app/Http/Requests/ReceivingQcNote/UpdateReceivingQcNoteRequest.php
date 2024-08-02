<?php

namespace App\Http\Requests\ReceivingQcNote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceivingQcNoteRequest extends FormRequest
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
        $receivingQcNoteId = $this->route('receiving_qc_note')->id;
        return [
            'code' => 'required|string|max:255|unique:receiving_qc_notes,code,' . $receivingQcNoteId,
            'notes' => 'required',
        ];
    }
}
