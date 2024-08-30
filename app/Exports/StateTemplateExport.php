<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class StateTemplateExport implements WithHeadings
{
    /**
     * Return the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'name',
            'code',
        ];
    }
}
