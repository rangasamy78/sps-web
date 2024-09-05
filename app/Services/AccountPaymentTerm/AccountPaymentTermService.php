<?php
namespace App\Services\AccountPaymentTerm;

use App\Models\AccountType;
use App\Models\AccountPaymentTerm;

class AccountPaymentTermService
{
    public function getAccountTypes()
    {
        return AccountType::query()->pluck('account_type_name','id');
    }

    public static function getAccountTypeList($id)
    {
        $accountTypeName = AccountType::query()
            ->where('id', $id)
            ->value('account_type_name');
        return $accountTypeName;
    }

    function getPaymentUsage($notUsedSales, $notUsedPurchases)
    {
        $result = '';
        if (!empty($notUsedSales) && !empty($notUsedPurchases)) {
            $result = 'Not Used in Purchases <br /> Not Used in Sales';
        } elseif (!empty($notUsedPurchases)) {
            $result = 'Not Used in Purchases';
        } elseif (!empty($notUsedSales)) {
            $result = 'Not Used in Sales';
        }
        return $result;
    }
}
