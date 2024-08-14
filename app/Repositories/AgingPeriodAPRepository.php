<?php

namespace App\Repositories;

use App\Models\AgingPeriodAP;

class AgingPeriodAPRepository
{
    public function save(array $data)
    {
        if ($data['id'] != '0') {
            AgingPeriodAP::query()
                ->findOrFail($data['id'])
                ->update($data);
            return $data['id'];
        } else {
            $query = AgingPeriodAP::query()
                ->create($data);
            return $query->id;
        }
    }
}
