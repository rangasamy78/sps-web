<?php


namespace App\Http\Requests\VendorPo;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrepaymentRequest extends FormRequest
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
        $vendorId = $this->route('vendor_pos'); 

        return [

            'vendor_id'         => 'required',
            'cash_account_id'   => 'required',
            'payment_method_id' => 'required',
            'check'             => 'required',

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

            'vendor_id.required'         => 'Vendor Id is required.',
            'cash_account_id.required'   => 'Cash Account is required.',
            'payment_method_id.required' => 'Payment Method is required.',

        ];
    }
}