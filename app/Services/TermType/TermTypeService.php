<?php

namespace App\Services\TermType;

use App\Models\TermType;

class TermTypeService
{
    public function getTermTypes()
    {
        return TermType::query()->select('term_type_name', 'id', 'type_id')->get()
                ->map(function ($term) {
                    return [
                        'value' => $term->id,
                        'label' => $term->term_type_name,
                        'type'  => $term->type_id,
                    ];
                });
    }
}
