<?php

namespace App\Services\LinkedAccount;

use App\Models\LinkedAccount;

class LinkedAccountService
{
    public function getFormatLinkedAccounts()
    {
        return LinkedAccount::query()
                ->select('id', 'account_code', 'account_name')
                ->get()
                ->map(function ($account) {
                    return [
                        'value' => $account->id,
                        'label' => $account->account_code . ' - ' . $account->account_name,
                    ];
                });
    }
}
