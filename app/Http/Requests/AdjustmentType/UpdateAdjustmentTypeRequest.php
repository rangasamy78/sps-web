<?php
namespace App\Http\Requests\AdjustmentType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdjustmentTypeRequest extends FormRequest
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
        $adjustment_type = $this->route('adjustment_type')->id;
        return [
            'adjustment_type' => 'required|string|max:255|unique:adjustment_types,adjustment_type,' . $adjustment_type,
        ];
    }


}
