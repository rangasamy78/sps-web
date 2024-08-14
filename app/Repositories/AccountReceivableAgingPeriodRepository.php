<?php

namespace App\Repositories;

use App\Models\AccountReceivableAgingPeriod;

class AccountReceivableAgingPeriodRepository
{
    public function save(array $data)
    {
        if (!isset($data['do_not_show_on_report'])) {
            $data['do_not_show_on_report'] = 0;
        }

        if (!empty($data['account_receivable_aging_period_id'])) {
            AccountReceivableAgingPeriod::query()
                ->findOrFail($data['account_receivable_aging_period_id'])
                ->update($data);
            return $data['account_receivable_aging_period_id'];
        } else {
            $query =  AccountReceivableAgingPeriod::query()
                ->create($data);
            return $query->id;
        }
    }
}
