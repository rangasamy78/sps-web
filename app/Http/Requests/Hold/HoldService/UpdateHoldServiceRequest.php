<?php

namespace App\Http\Requests\Hold\HoldService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHoldServiceRequest extends FormRequest
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
            'service_id.*' => 'nullable|string',
            'service_description.*' => 'nullable|string|max:255',
            'service_quantity.*' => [
                'nullable',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1]; // Get the index of the current field
                    $serviceId = request('service_id')[$index] ?? null; // Get the corresponding service_id

                    if ($serviceId && $serviceId !== 'null' && !$value) {
                        $fail("The {$attribute} field is required when service_id is set.");
                    }
                },
            ],
            'service_unit_price.*' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $serviceId = request('service_id')[$index] ?? null;

                    if ($serviceId && $serviceId !== 'null' && !$value) {
                        $fail("The {$attribute} field is required when service_id is set.");
                    }
                },
            ],
            'service_amount.*' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $serviceId = request('service_id')[$index] ?? null;

                    if ($serviceId && $serviceId !== 'null' && !$value) {
                        $fail("The {$attribute} field is required when service_id is set.");
                    }
                },
            ],
            'is_tax.*' => 'nullable|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
}
