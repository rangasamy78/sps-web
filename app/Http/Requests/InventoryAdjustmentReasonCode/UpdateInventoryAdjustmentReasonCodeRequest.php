<?php
namespace App\Http\Requests\InventoryAdjustmentReasonCode;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryAdjustmentReasonCodeRequest extends FormRequest
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
        $inventory_adjustment_reason_code = $this->route('inventory_adjustment_reason_code')->id;
        return [
            'reason'                    => 'required|string|max:255|unique:inventory_adjustment_reason_codes,reason,' . $inventory_adjustment_reason_code,
            'adjustment_type_id'        => 'required|integer',
            'income_expense_account_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
         return [
            'adjustment_type_id.required'           => 'The adjustment type field is required.',
            'income_expense_account_id.required'    => 'The income expense account field is required.',
         ];
    }
}
