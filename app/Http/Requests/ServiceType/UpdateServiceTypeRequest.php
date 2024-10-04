<?php

namespace App\Http\Requests\ServiceType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceTypeRequest extends FormRequest
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
            'service_type' => 'required|string|max:255|unique:service_types,service_type,' . $this->route('service_type')->id
        ];
    }
}
