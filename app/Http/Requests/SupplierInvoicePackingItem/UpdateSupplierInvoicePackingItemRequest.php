<?php
namespace App\Http\Requests\SupplierInvoicePackingItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierInvoicePackingItemRequest extends FormRequest
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
            'pack_length' => 'required',
            'pack_width' => 'required',
        ];
    }
}
