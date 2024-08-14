<?php

namespace App\Repositories;

use App\Models\DefaultLinkAccountSale;
use App\Models\DefaultLinkAccountAccounting;
use App\Models\DefaultLinkAccountInventoryAsset;
use App\Models\DefaultLinkAccountBankingPayment;
use App\Models\DefaultLinkAccountBankingReceipt;
use App\Models\DefaultLinkAccountInventoryAdjustment;
use App\Models\DefaultLinkInventoryInTransitOnTransfer;
use App\Models\DefaultLinkAccountOtherChargesDiscountsVariance;

Class DefaultLinkAccountRepository {

    public function inventoryAssetSave(array $data)
    {
        $model = DefaultLinkAccountInventoryAsset::updateOrCreate(
            [   'id' => $data['id']],
            [
                'account_for_new_product_id' => $data['account_for_new_product_id'],
            ]
        );
        return $model;
    }

    public function inventoryInTransitOnTransferSave(array $data)
    {
        $model = DefaultLinkInventoryInTransitOnTransfer::updateOrCreate(
            [   'id' => $data['id']],
            [
                'inventory_in_transit_id' => $data['inventory_in_transit_id'],
            ]
        );
        return $model;
    }

    public function inventoryAdjustmentSave(array $data)
    {
        $model = DefaultLinkAccountInventoryAdjustment::updateOrCreate(
            [   'id' => $data['id']],
            [
                'positive_adjustment_id' => $data['positive_adjustment_id'],
                'inventory_write_off_id' => $data['inventory_write_off_id'],
                'reclassify_renumbering_split_id' => $data['reclassify_renumbering_split_id'],
                'revaluation_adjustment_id' => $data['revaluation_adjustment_id'],
            ]
        );
        return $model;
    }

    public function bankingPaymentSave(array $data)
    {
        $model = DefaultLinkAccountBankingPayment::updateOrCreate(
            [   'id' => $data['id']],
            [
                'supplier_payment_cash_account_id' => $data['supplier_payment_cash_account_id'],
                'vendor_payment_cash_account_id' => $data['vendor_payment_cash_account_id'],
                'customer_payment_cash_account_id' => $data['customer_payment_cash_account_id'],
                'miscellaneous_expense_id' => $data['miscellaneous_expense_id'],
            ]
        );
        return $model;
    }

    public function otherChargesDiscountsVarianceSave(array $data)
    {
        $model = DefaultLinkAccountOtherChargesDiscountsVariance::updateOrCreate(
            [   'id' => $data['id']],
            [
                'other_charges_in_po_sipl_id' => $data['other_charges_in_po_sipl_id'],
                'payments_discount_id' => $data['payments_discount_id'],
                'restocking_fees_on_pur_return_id' => $data['restocking_fees_on_pur_return_id'],
                'freight_account_on_purchase_id' => $data['freight_account_on_purchase_id'],
                'supplier_invoice_variance_id' => $data['supplier_invoice_variance_id'],
                'supp_credit_memos_variance_id' => $data['supp_credit_memos_variance_id'],
            ]
        );
        return $model;
    }

    public function saleSave(array $data)
    {
        $model = DefaultLinkAccountSale::updateOrCreate(
            [   'id' => $data['id']],
            [
                'customer_ar_id' => $data['customer_ar_id'],
                'sales_income_product_id' => $data['sales_income_product_id'],
                'sales_income_service_id' => $data['sales_income_service_id'],
                'cogs_account_id' => $data['cogs_account_id'],
                'restocking_fee_income_account_id' => $data['restocking_fee_income_account_id'],
                'sales_tax_liability_account_id' => $data['sales_tax_liability_account_id'],
                'sales_discount_id' => $data['sales_discount_id'],
            ]
        );
        return $model;
    }

    public function accountingSave(array $data)
    {
        $model = DefaultLinkAccountAccounting::updateOrCreate(
            [   'id' => $data['id']],
            [
                'retained_earning_id' => $data['retained_earning_id'],
            ]
        );
        return $model;
    }

    public function bankingReceiptSave(array $data)
    {
        $model = DefaultLinkAccountBankingReceipt::updateOrCreate(
            [   'id' => $data['id']],
            [
                'receipt_cash_account_id' => $data['receipt_cash_account_id'],
                'miscellaneous_income_id' => $data['miscellaneous_income_id']
            ]
        );
        return $model;
    }

}
