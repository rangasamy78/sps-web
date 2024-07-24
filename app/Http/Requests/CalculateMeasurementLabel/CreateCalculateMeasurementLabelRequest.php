<?php

namespace App\Http\Requests\CalculateMeasurementLabel;

use Illuminate\Foundation\Http\FormRequest;

class CreateCalculateMeasurementLabelRequest extends FormRequest
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
            'label_name' => 'required|string|max:255|unique:calculate_measurement_labels,label_name',
        ];
    }
}
