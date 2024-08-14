<?php

namespace App\Services\AccountType;

use App\Models\AccountType;

class AccountTypeService
{
    public function getAccountTypes()
    {
        return AccountType::query()->select('account_type_name', 'id')->get()
                ->map(function ($account) {
                    return [
                        'value' => $account->id,
                        'label' => $account->account_type_name,
                    ];
                });
    }
}
