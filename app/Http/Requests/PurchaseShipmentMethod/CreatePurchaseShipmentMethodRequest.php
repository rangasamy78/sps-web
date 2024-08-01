<?php

namespace App\Http\Requests\PurchaseShipmentMethod;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseShipmentMethodRequest extends FormRequest
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
            'shipment_method_name' => 'required|string|max:255|unique:purchase_shipment_methods,shipment_method_name',
        ];
    }
}
