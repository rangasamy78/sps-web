<?php

namespace App\Repositories;

use App\Models\Visit;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;

class VisitCalendarRepository implements CrudRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return Visit::query()
            ->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $query = Visit::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function update1(array $data, int $id)
    {
        $query = Opportunity::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function store(array $data)
    {
    }

    public function delete(int $id)
    {
    }

}
