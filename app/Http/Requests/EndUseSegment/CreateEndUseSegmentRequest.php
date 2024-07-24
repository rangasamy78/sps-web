<?php

namespace App\Http\Requests\EndUseSegment;

use Illuminate\Foundation\Http\FormRequest;

class CreateEndUseSegmentRequest extends FormRequest
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
            'end_use_segment' => 'required|string|max:255|unique:end_use_segments,end_use_segment',
        ];

    }
}
