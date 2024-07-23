<?php

namespace App\Http\Requests\Designation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Designation;

class CreateDesignationRequest extends FormRequest
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
            'designation_name_.*' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1]; // Get index from attribute
                    $departmentId = $this->input('department_id_.' . $index); // Get department ID using index

                    // Check for uniqueness within the department
                    if (Designation::where('designation_name', $value)
                        ->where('department_id', $departmentId)
                        ->exists()
                    ) {
                        $fail('Designation name must be unique in this department');
                    }
                },
            ],
            'department_id_.*' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'designation_name_.*.required' => 'Designation Name is required.',
            'designation_name_.*.string' => 'Designation Name must be a string for all entries.',
            'designation_name_.*.max' => 'Designation Name must not exceed 255 characters for all entries.',
            'department_id_.*.required' => 'Department is required.',
        ];
    }
}
