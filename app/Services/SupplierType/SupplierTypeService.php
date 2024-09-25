<?php

namespace App\Services\SupplierType;

use App\Models\SupplierType;

class SupplierTypeService
{
    public function getSupplierTypes()
    {
        return SupplierType::query()->pluck('supplier_type_name', 'id');
    }
}
