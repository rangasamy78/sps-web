<?php

namespace App\Rules;

use Closure;
use App\Models\Company;
use Illuminate\Contracts\Validation\ValidationRule;

class CompanyLimit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $companyCount = Company::query()->count();
        if ($companyCount >= 1 ) {
            $fail('You cannot add more than one :attribute');
        }
    }
}
