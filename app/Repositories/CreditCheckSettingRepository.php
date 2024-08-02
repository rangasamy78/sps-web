<?php

namespace App\Repositories;

use App\Models\CreditCheckSetting;

class CreditCheckSettingRepository
{
    public function save(array $data)
    {
        if ($data['id'] != "0") {
            CreditCheckSetting::query()
                ->findOrFail($data['id'])
                ->update($data);
            return $data['id'];
        } else {
            $query =  CreditCheckSetting::query()
                ->create($data);
            return $query->id;
        }
    }
}
