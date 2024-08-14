<?php

namespace App\Repositories;

use App\Services\Country\CountryService;
use App\Interfaces\DropDownRepositoryInterface;
use App\Services\AccountType\AccountTypeService;
use App\Services\LinkedAccount\LinkedAccountService;

class DropDownRepository implements DropDownRepositoryInterface
{
    public $countryService;
    public $accountTypeService;
    public $linkedAccountService;
    public function __construct(CountryService $countryService, LinkedAccountService $linkedAccountService, AccountTypeService $accountTypeService)
    {
        $this->countryService = $countryService;
        $this->accountTypeService = $accountTypeService;
        $this->linkedAccountService = $linkedAccountService;
    }

    public function dropDownPopulate(string $tableName)
    {
        switch ($tableName) {
            case 'countries':
                return $this->countryService->getCountries();
            case 'linked_accounts':
                return $this->linkedAccountService->getFormatLinkedAccounts();
            case 'account_types':
                return $this->accountTypeService->getAccountTypes();
            default:
                throw new \InvalidArgumentException("Dropdown type '{$tableName}' is not supported.");
        }
    }
}
