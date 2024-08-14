<?php

namespace App\Services\AdjustmentType;

use App\Models\AdjustmentType;

class AdjustmentTypeService
{
    public function getAdjustmentTypes()
    {
        return AdjustmentType::query()->pluck('adjustment_type','id');
    }
}
