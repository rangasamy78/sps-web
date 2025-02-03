<?php

namespace App\Http\Requests\CustomerBinType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerBinTypeRequest extends FormRequest
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
        $customerTypeId = $this->route('customer_bin_type')->id;
        return [
            'label' => 'required|string|max:255|unique:customer_bin_types,label,' . $customerTypeId,
        ];
    }
}
