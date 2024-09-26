<?php

namespace App\Services\VendorType;

use App\Models\VendorType;

class VendorTypeService
{
    public function getVendorTypes()
    {
        return VendorType::query()->select('vendor_type_name', 'id')->get()
                ->map(function ($account) {
                    return [
                        'value' => $account->id,
                        'label' => $account->vendor_type_name,
                    ];
                });
    }
}
