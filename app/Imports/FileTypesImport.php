<?php

namespace App\Imports;

use App\Models\FileType;
use App\Helpers\ImportHelper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FileTypesImport implements ToModel, WithValidation, SkipsOnFailure, WithHeadingRow
{
    use Importable, SkipsFailures;

    public $errors = [];

    public function model(array $row)
    {
        $view_in   = trim($row['view_in'] ?? null);
        $file_type = trim($row['file_type'] ?? null);

        return new FileType([
            'view_in'   => $view_in,
            'file_type' => $file_type,
        ]);
    }

    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'view_in'   => 'required',
            'file_type' => 'required|unique:file_types,file_type',
        ];
    }

    /**
     * Handle validation failures.
     *
     * @param  Failure[]  $failures
     */
    public function onFailure(Failure ...$failures)
    {
        $this->errors[] = ImportHelper::formatFailures(...$failures);
    }
}
