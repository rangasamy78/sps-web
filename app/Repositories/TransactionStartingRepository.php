<?php

namespace App\Repositories;

use App\Models\TransactionStarting;

class TransactionStartingRepository
{
    public function save(array $data)
    {
        if (!empty($data['transaction_starting_number_id'])) {
            TransactionStarting::query()
                ->findOrFail($data['transaction_starting_number_id'])
                ->update($data);
            return $data['transaction_starting_number_id'];
        } else {
            $query = TransactionStarting::query()
                ->create($data);
            return $query->id;
        }
    }
}
