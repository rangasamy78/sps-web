<?php

namespace App\Http\Requests\Designation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateDesignationRequest extends FormRequest
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
        $designationId = $this->designation ? $this->designation->id : null;
        $dptId = $this->input('department_id'); // Assuming this is how you get the department ID

        return [
            'designation_name' => [
                'required',
                'max:255',
                Rule::unique('designations', 'designation_name')
                    ->where(function ($query) use ($dptId) {
                        return $query->where('department_id', $dptId);
                    })
                    ->ignore($designationId, 'id')
            ],
            'department_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'designation_name.required' => 'Designation is required',
            'designation_name.max'      => 'Designation must not exceed 255 characters',
            'department_id.required'    => 'Department is required.',
            'designation_name.unique'   => 'The designation name must be unique within the selected department',
        ];
    }
}
