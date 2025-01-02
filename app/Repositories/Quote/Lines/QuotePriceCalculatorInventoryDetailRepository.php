<?php

namespace App\Repositories\Quote\Lines;

use App\Models\QuotePriceCalculatorInventoryDetail;

class QuotePriceCalculatorInventoryDetailRepository
{
    public function findOrFail(int $id)
    {
        return QuotePriceCalculatorInventoryDetail::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuotePriceCalculatorInventoryDetail::insert($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }
}
