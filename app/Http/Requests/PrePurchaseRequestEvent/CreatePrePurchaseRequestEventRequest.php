<?php

namespace App\Http\Requests\PrePurchaseRequestEvent;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrePurchaseRequestEventRequest extends FormRequest
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
            'event_type_id' => 'required',
            'assigned_to_id' => 'required',
            'event_title' => 'required',
            'product_id' => 'required',
            'price' => 'required',
        ];
    }
}
