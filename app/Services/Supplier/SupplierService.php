<?php

namespace App\Services\Supplier;

use App\Models\SupplierType;
use App\Repositories\DropDownRepository;

class SupplierService
{
    public $dropDownRepository;

    public function __construct(DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
    }

    public function getAllData()
    {
        return [
            'supplierTypes' => $this->dropDownRepository->dropDownPopulate('supplier_types'),
        ];
    }
}
