<?php

namespace App\Services\TaxCode;

use App\Models\TaxCode;

class TaxCodeService
{
    public function getNextSortOrder()
    {
        $lastSortOrder = TaxCode::orderBy('sort_order', 'desc')->first();

        return $lastSortOrder ? $lastSortOrder->sort_order + 10 : 10;
    }
}
