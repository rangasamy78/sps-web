<?php

namespace App\Repositories;

use App\Models\PickTicketRestriction;

class PickTicketRestrictionRepository
{
    public function save(array $data)
    {
        if ($data['id'] != '0') {
            PickTicketRestriction::query()
                ->findOrFail($data['id'])
                ->update($data);
            return $data['id'];
        } else {
            $query = PickTicketRestriction::query()
                ->create($data);
            return $query->id;
        }

    }
}
