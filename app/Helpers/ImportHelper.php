<?php

namespace App\Helpers;

use Maatwebsite\Excel\Validators\Failure;

class ImportHelper
{
    public static function formatFailures(Failure ...$failures)
    {
        $rowErrors = [];
        foreach ($failures as $failure) {
            $rowNumber = $failure->row();
            $errors    = $failure->errors();

            if (!isset($rowErrors[$rowNumber])) {
                $rowErrors[$rowNumber] = [];
            }

            $rowErrors[$rowNumber] = array_merge($rowErrors[$rowNumber], $errors);
        }

        $formattedErrors = [];
        foreach ($rowErrors as $rowNumber => $errors) {
            if (count($errors) > 1) {
                $lastError    = array_pop($errors);
                $errorsString = implode(', ', $errors) . ' And ' . $lastError;
            } else {
                $errorsString = $errors[0];
            }
            $formattedErrors[] = 'Row ' . $rowNumber . ': ' . $errorsString;
        }

        return $formattedErrors;
    }
}
