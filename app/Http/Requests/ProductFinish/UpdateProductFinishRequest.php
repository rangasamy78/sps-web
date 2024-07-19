<?php
namespace App\Http\Requests\ProductFinish;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductFinishRequest extends FormRequest
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
        $productFinishId = $this->route('product_finish')->id;
        return [
            'product_finish_code' => [
                'required',
                Rule::unique('product_finishes')->where(function ($query) {
                    return $query->where('product_finish_code', $this->input('product_finish_code'))
                        ->where('finish', $this->input('finish'));
                })->ignore($productFinishId),
            ],
            'finish' => [
                'required',
                Rule::unique('product_finishes')->where(function ($query) {
                    return $query->where('product_finish_code', $this->input('product_finish_code'))
                        ->where('finish', $this->input('finish'));
                })->ignore($productFinishId),
            ],
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
            'product_finish_code.unique' => 'The combination of Product Finish Code and Finish has already been taken.',
            'finish.unique' => 'The combination of Product Finish Code and Finish has already been taken.',
        ];
    }
}
