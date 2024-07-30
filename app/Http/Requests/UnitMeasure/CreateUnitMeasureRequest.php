<?php

namespace App\Http\Requests\UnitMeasure;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUnitMeasureRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'unit_measure_entity' => [
                'required',
                Rule::unique('unit_measures')->where(function ($query) {
                    return $query->where('unit_measure_entity', $this->input('unit_measure_entity'))
                                 ->where('unit_measure_name', $this->input('unit_measure_name'));
                })->ignore($this->route('unit_measure')), 
            ],
            'unit_measure_name' => [
                'required',
                Rule::unique('unit_measures')->where(function ($query) {
                    return $query->where('unit_measure_entity', $this->input('unit_measure_entity'))
                                 ->where('unit_measure_name', $this->input('unit_measure_name'));
                })->ignore($this->route('unit_measure')), 
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
            'unit_measure_entity.unique' => 'The combination of Unit Measure Entity and Name has already been taken.',
            'unit_measure_name.unique' => 'The combination of Unit Measure Entity and Name has already been taken.',
        ];
    }
}
