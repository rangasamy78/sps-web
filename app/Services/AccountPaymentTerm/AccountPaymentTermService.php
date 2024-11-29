<?php
namespace App\Services\AccountPaymentTerm;

use App\Models\TermType;
use App\Models\AccountType;
use App\Models\AccountPaymentTerm;

class AccountPaymentTermService
{
    public function getAccountTypes()
    {
        return AccountType::query()->pluck('account_type_name','id');
    }

    public static function getTermTypeList($id)
    {
        $termTypeName = TermType::query()
            ->where('id', $id)
            ->value('term_type_name');
        return $termTypeName;
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
