<?php

namespace App\Services\PaymentMethod;

use App\Repositories\DropDownRepository;

class PaymentMethodService
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
            'accountTypes' => $this->dropDownRepository->dropDownPopulate('account_types'),
        ];
    }
}
