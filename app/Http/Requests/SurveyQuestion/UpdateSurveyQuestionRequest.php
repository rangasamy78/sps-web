<?php

namespace App\Http\Requests\SurveyQuestion;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyQuestionRequest extends FormRequest
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
        $surveyQuestionId = $this->route('survey_question')->id;
        return [
            'transaction' => 'required|string|max:255',
            'short_label' => 'required|string|max:255',
            'question' => [
                'required',
                'string',
                'max:255',
                Rule::unique('survey_questions')
                    ->where('question', $this->input('question'))
                    ->ignore($surveyQuestionId),
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
            'question.unique' => 'The combination of Survey Question Short Label and|or Question has already been taken for the same Transaction.',
        ];
    }
}
