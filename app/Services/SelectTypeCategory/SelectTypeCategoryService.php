<?php

namespace App\Services\SelectTypeCategory;

use App\Models\SelectTypeCategory;

class SelectTypeCategoryService
{
    public function getSelectTypeCategory()
    {
        return SelectTypeCategory::query()->pluck('select_type_category_name','id');
    }
}