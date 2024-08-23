<?php

namespace App\Imports;

use App\Helpers\ImportHelper;
use App\Models\State;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class StatesImport implements ToModel, WithValidation, SkipsOnFailure, WithHeadingRow
{
    use Importable, SkipsFailures;

    public $errors = [];

    public function model(array $row)
    {
        $name = trim($row['name'] ?? null);
        $code = trim($row['code'] ?? null);

        return new State([
            'name' => $name,
            'code' => $code,
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
            'name' => 'required|unique:states,name',
            'code' => 'required|unique:states,code',
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
