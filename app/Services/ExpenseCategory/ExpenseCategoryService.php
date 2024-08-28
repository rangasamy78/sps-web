<?php

namespace App\Services\ExpenseCategory;

use App\Repositories\DropDownRepository;

class ExpenseCategoryService
{
    public $dropDownRepository;

    public function __construct(DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
    }

    public function getAllData()
    {
        return [
            'linkedAccounts' => $this->dropDownRepository->dropDownPopulate('linked_accounts'),
        ];
    }
}
