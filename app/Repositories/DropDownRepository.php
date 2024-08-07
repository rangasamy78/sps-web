<?php

namespace App\Repositories;

use App\Services\Country\CountryService;
use App\Services\LinkedAccount\LinkedAccountService;
use App\Interfaces\DropDownRepositoryInterface;

class DropDownRepository implements DropDownRepositoryInterface
{

    public $countryService;
    public $linkedAccountService;
    public function __construct(CountryService $countryService, LinkedAccountService $linkedAccountService)
    {
        $this->countryService = $countryService;
        $this->linkedAccountService = $linkedAccountService;
    }

    public function dropDownPopulate(string $modelName)
    {
        switch ($modelName) {
            case 'countries':
                return $this->countryService->getCountries();
            case 'linked_accounts':
                return $this->linkedAccountService->getLinkedAccount();
            default:
                throw new \InvalidArgumentException("Dropdown type '{$modelName}' is not supported.");
        }
    }
}
