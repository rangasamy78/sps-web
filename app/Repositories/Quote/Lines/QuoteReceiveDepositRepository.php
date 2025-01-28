<?php

namespace App\Repositories\Quote\Lines;

use App\Models\QuoteReceiveDeposit;

class QuoteReceiveDepositRepository
{
    public function findOrFail(int $id)
    {
        return QuoteReceiveDeposit::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuoteReceiveDeposit::create($data);
    }

    public function update(array $data, $id)
    {
        $query = QuoteReceiveDeposit::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }
}
