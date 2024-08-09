<?php

namespace App\Repositories;

use App\Services\Country\CountryService;
use App\Interfaces\DropDownRepositoryInterface;
use App\Services\AccountPaymentTerm\AccountPaymentTermService;

Class DropDownRepository implements DropDownRepositoryInterface {

    public $countryService, $accountPaymentTermService;
    public function __construct(CountryService $countryService, AccountPaymentTermService $accountPaymentTermService)
    {
        $this->countryService = $countryService;
        $this->accountPaymentTermService = $accountPaymentTermService;
    }

    public function dropDownPopulate(string $modelName)
    {
        switch ($modelName) {
            case 'countries':
                return $this->countryService->getCountries();
            case 'account_types':
                return $this->accountPaymentTermService->getAccountTypes();
            default:
                throw new \InvalidArgumentException("Dropdown type '{$modelName}' is not supported.");
        }
    }
}
