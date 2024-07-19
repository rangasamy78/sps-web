<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    public function findOrFail(int $id);

    public function store(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);
}
