<?php

namespace App\Repositories;

use App\Services\Country\CountryService;
use App\Services\TermType\TermTypeService;
use App\Interfaces\DropDownRepositoryInterface;
use App\Services\AccountType\AccountTypeService;
use App\Services\LinkedAccount\LinkedAccountService;
use App\Services\AdjustmentType\AdjustmentTypeService;
use App\Services\SelectTypeCategory\SelectTypeCategoryService;

class DropDownRepository implements DropDownRepositoryInterface
{
    public $countryService;
    public $termTypeService;
    public $accountTypeService;
    public $linkedAccountService;
    public $adjustmentTypeService;
    public $selectTypeCategoryService;

    public function __construct(CountryService $countryService, AccountTypeService $accountTypeService, TermTypeService $termTypeService, LinkedAccountService $linkedAccountService, AdjustmentTypeService $adjustmentTypeService, SelectTypeCategoryService $selectTypeCategoryService)
    {
        $this->countryService = $countryService;
        $this->termTypeService = $termTypeService;
        $this->accountTypeService = $accountTypeService;
        $this->linkedAccountService = $linkedAccountService;
        $this->adjustmentTypeService = $adjustmentTypeService;
        $this->selectTypeCategoryService = $selectTypeCategoryService;
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
            case 'term_types':
                return $this->termTypeService->getTermTypes();
            case 'adjustment_types':
                return $this->adjustmentTypeService->getAdjustmentTypes();
            case 'select_type_categories':
                return $this->selectTypeCategoryService->getSelectTypeCategory();
            case 'linked_account_inventory_gl':
                return $this->linkedAccountService->getFormatLinkedInventoryGlAccounts();
            default:
                throw new \InvalidArgumentException("Dropdown type '{$tableName}' is not supported.");
        }
    }
}
