<?php

namespace App\Repositories;

use App\Services\Country\CountryService;
use App\Interfaces\DropDownRepositoryInterface;
use App\Services\LinkedAccount\LinkedAccountService;
use App\Services\AccountPaymentTerm\AccountPaymentTermService;

class DropDownRepository implements DropDownRepositoryInterface
{
    public $countryService;
    public $linkedAccountService;
    public $accountPaymentTermService;
    public function __construct(CountryService $countryService, LinkedAccountService $linkedAccountService, AccountPaymentTermService $accountPaymentTermService)
    {
        $this->countryService = $countryService;
        $this->linkedAccountService = $linkedAccountService;
        $this->accountPaymentTermService = $accountPaymentTermService;
    }

    public function dropDownPopulate(string $tableName)
    {
        switch ($tableName) {
            case 'countries':
                return $this->countryService->getCountries();
            case 'account_types':
                return $this->accountPaymentTermService->getAccountTypes();
            case 'linked_accounts':
                return $this->linkedAccountService->getFormatLinkedAccounts();
            default:
                throw new \InvalidArgumentException("Dropdown type '{$tableName}' is not supported.");
        }
    }
}
