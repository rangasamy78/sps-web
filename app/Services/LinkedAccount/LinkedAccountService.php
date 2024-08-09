<?php

namespace App\Services\LinkedAccount;

use App\Models\LinkedAccount;

class LinkedAccountService
{
    public function getLinkedAccount()
    {
        return LinkedAccount::query()->select('id', 'account_code', 'account_name')->get();
    }
}
