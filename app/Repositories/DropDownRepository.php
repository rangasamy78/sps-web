<?php

namespace App\Repositories;

use App\Services\Country\CountryService;
use App\Interfaces\DropDownRepositoryInterface;

Class DropDownRepository implements DropDownRepositoryInterface {

    public $countryService;
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function dropDownPopulate(string $modelName)
    {
        switch ($modelName) {
            case 'countries':
                return $this->countryService->getCountries();
            default:
                throw new \InvalidArgumentException("Dropdown type '{$modelName}' is not supported.");
        }
    }
}
