<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\VisitCalendar;
use App\Interfaces\CrudRepositoryInterface;

class EventCalendarRepository implements CrudRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return VisitCalendar::query()
            ->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $query = VisitCalendar::query()
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
