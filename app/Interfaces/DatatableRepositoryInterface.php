<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DatatableRepositoryInterface
{
    public function dataTable(Request $request);
}
