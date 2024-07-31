<?php

namespace App\Http\Requests\UnitMeasure;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitMeasureRequest extends FormRequest
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
        $unitMeasureId = $this->route('unit_measure')->id;
        return [
            'unit_measure_entity' => 'required|string|max:255',
            'unit_measure_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('unit_measures')
                    ->where('unit_measure_entity', $this->input('unit_measure_entity'))
                    ->ignore($unitMeasureId),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'unit_measure_name.unique' => 'The Unit Measure Name has already been taken for the selected Unit Measure Entity.',
        ];
    }
}
