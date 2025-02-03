<?php

namespace App\Services\LinkedAccount;

use App\Models\Account;
use App\Models\LinkedAccount;

class LinkedAccountService
{
    public function getFormatLinkedAccounts()
    {
        return Account::select('id', 'account_number', 'account_name')
        ->whereHas('account_type', function ($query) {
            $query->whereIn('account_type_name', [
                Account::TYPE_INVENTORY,
                Account::TYPE_SALES,
                Account::TYPE_COGS
            ]);
        })
        ->get()
        ->map(fn($account) => [
            'value' => $account->id,
            'label' => $account->account_number . ' - ' . $account->account_name,
        ]);
    }

    public function getFormatLinkedInventoryGlAccounts()
    {
        return LinkedAccount::query()
                ->select('linked_accounts.id', 'account_code', 'account_name', 'account_type_name')
                ->leftJoin('account_types', 'linked_accounts.account_type', '=', 'account_types.id')
                ->get()
                ->map(function ($account) {
                    return [
                        'value' => $account->id,
                        'type'  => $account->account_type_name,
                        'label' => $account->account_code . ' - ' . $account->account_name,
                    ];
                });
    }
}
