<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class FileProductRequest extends FormRequest
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
           'product_id'   => 'required',
            'file'         => 'required|array|min:1',        
            'file.*'       => 'file|mimes:jpeg,jpg,png,gif,bmp,pdf|max:10240',
           
        ];
    }
    

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required'   => 'A valid product must be selected.',
            'file.required'         => 'You must upload at least one file.',
            'file.*.file'           => 'Each file must be a valid file type.',
            'file.*.mimes'          => 'Files must be of type: jpeg, jpg, png, gif, bmp, pdf.',
            'file.*.max'            => 'Each file must not exceed 10MB.',
           
        ];
    }
}
