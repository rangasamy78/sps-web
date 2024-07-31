<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DropDownRepositoryInterface
{
    public function dropDownPopulate(string $dropdownType);
}
