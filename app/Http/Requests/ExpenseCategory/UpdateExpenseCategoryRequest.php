<?php

namespace App\Http\Requests\ExpenseCategory;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseCategoryRequest extends FormRequest
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
            'expense_category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('expense_categories')->where(function ($query) {
                    return $query->where('expense_account', $this->input('expense_account'));
                })->ignore($this->route('expense_category')->id,),
            ],
            'expense_account' => 'required|integer',
        ];
    }
}
