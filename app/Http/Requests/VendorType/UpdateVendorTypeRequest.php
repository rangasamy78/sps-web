<?php
namespace App\Http\Requests\VendorType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorTypeRequest extends FormRequest
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
        $vendor_type = $this->route('vendor_type')->id;
        return [
            'vendor_type_name' => 'required|string|max:255|unique:vendor_types,vendor_type_name,' . $vendor_type,
        ];
    }
}
