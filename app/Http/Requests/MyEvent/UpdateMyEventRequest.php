<?php

namespace App\Http\Requests\MyEvent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyEventRequest extends FormRequest
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
            'event_title'       => 'required',
            'event_type_id'     => 'required',
            'assigned_to_id'    => 'required',
        ];

    }
    public function messages(): array
    {
        return [
            'event_title.required'      => 'The title field is required.',
            'event_type_id.required'    => 'The event type field is required.',
            'assigned_to_id.required'   => 'The assigned cc is required.',
        ];
    }
}
