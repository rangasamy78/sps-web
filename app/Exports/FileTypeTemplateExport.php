<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class FileTypeTemplateExport implements WithHeadings
{
    /**
     * Return the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'view_in',
            'file_type',
        ];
    }
}
