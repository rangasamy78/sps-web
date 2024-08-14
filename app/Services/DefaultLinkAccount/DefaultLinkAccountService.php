<?php

namespace App\Services\DefaultLinkAccount;

use App\Models\DefaultLinkAccountSale;
use App\Repositories\DropDownRepository;
use App\Models\DefaultLinkAccountAccounting;
use App\Models\DefaultLinkAccountBankingReceipt;
use App\Models\DefaultLinkAccountBankingPayment;
use App\Models\DefaultLinkAccountInventoryAsset;
use App\Models\DefaultLinkAccountInventoryAdjustment;
use App\Models\DefaultLinkInventoryInTransitOnTransfer;
use App\Models\DefaultLinkAccountOtherChargesDiscountsVariance;

class DefaultLinkAccountService
{
    protected DropDownRepository $dropDownRepository;

    public function __construct(DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
    }

    public function getAllData()
    {
        return [
            'linkedAccounts' => $this->dropDownRepository->dropDownPopulate('linked_accounts'),
            'inventoryAsset' => DefaultLinkAccountInventoryAsset::query()->latest()->first(),
            'inventoryInTransitOnTransfer' => DefaultLinkInventoryInTransitOnTransfer::query()->latest()->first(),
            'inventoryAdjustment' => DefaultLinkAccountInventoryAdjustment::query()->latest()->first(),
            'bankingPayment' => DefaultLinkAccountBankingPayment::query()->latest()->first(),
            'otherCharge' => DefaultLinkAccountOtherChargesDiscountsVariance::query()->latest()->first(),
            'sale' => DefaultLinkAccountSale::query()->latest()->first(),
            'accounting' => DefaultLinkAccountAccounting::query()->latest()->first(),
            'bankingReceipt' => DefaultLinkAccountBankingReceipt::query()->latest()->first(),
        ];
    }
}
