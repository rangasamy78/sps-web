<?php

namespace App\Services\TaxComponent;

use App\Models\TaxComponent;

class TaxComponentService
{
    public function getNextSortOrder()
    {
        $lastSortOrder = TaxComponent::orderBy('sort_order', 'desc')->first();

        return $lastSortOrder ? $lastSortOrder->sort_order + 10 : 10;
    }
}
