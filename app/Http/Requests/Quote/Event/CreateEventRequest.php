<?php

namespace App\Http\Requests\Quote\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'entered_by_id'    => 'required|integer',
            'event_type_id'    => 'nullable|integer',
            'schedule_date'    => 'nullable|date',
            'schedule_time'    => 'nullable|date_format:H:i',
            'assigned_to_id'   => 'required|integer',
            'follower_id'      => 'nullable|integer',
            'event_title'      => 'nullable|string|max:255',
            'party_name'       => 'nullable|string|max:255',
            'product_id'       => 'nullable|integer',
            'price'            => 'nullable|numeric',
            'description'      => 'nullable|string|max:1000',
            'type'             => 'required|string|max:50',
            'type_id'          => 'required|integer',
            'mark_as_complete' => 'nullable|boolean',
        ];
    }
}
