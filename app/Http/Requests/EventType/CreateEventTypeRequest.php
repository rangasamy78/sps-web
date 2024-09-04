<?php

namespace App\Http\Requests\EventType;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventTypeRequest extends FormRequest
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
            'event_type_name'   => 'required|string|max:255|unique:event_types,event_type_name',
            'event_category_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'event_category_id.required' => 'Event category is required.',
            'event_category_id.integer'  => 'Event category must be an integer.',
        ];
    }


}
