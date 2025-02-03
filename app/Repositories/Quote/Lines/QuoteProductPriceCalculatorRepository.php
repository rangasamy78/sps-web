<?php

namespace App\Repositories\Quote\Lines;

use App\Models\QuoteProductPriceCalculator;

class QuoteProductPriceCalculatorRepository
{
    public function findOrFail(int $id)
    {
        return QuoteProductPriceCalculator::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuoteProductPriceCalculator::create($data);
    }

    public function findByQuoteProductId($quoteProductId)
    {
        return QuoteProductPriceCalculator::where('quote_product_id', $quoteProductId)->first();
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }
}
