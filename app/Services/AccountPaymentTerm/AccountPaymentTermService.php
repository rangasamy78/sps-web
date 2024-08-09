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

    public function getAccountPaymentTermLabel($netDueDay, $paymentType)
    {
        $result = '';
        if (($paymentType == 1) && !empty($netDueDay)) {
            $result = (($netDueDay == 1) ? ' Day' : ' Days');
        } elseif (($paymentType == 2) && !empty($netDueDay)) {
            $result = ' th of Month';
        }
        return $netDueDay.$result;                       
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