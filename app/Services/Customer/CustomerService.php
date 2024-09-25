<?php

namespace App\Services\Customer;

use App\Models\Country;
use App\Models\Customer;
use App\Repositories\DropDownRepository;

class CustomerService
{
    public $dropDownRepository;

    public function __construct(DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
    }

    public function getCustomers()
    {
        return Customer::query()->pluck('customer_name','id');
    }

    public function getAllData()
    {
        return [
            'countries' => Country::query()->pluck('country_name','id'),
            'customers' => Customer::query()->pluck('customer_name','id'),
        ];
    }

    public function getBillingAddress($customerId)
    {
        $customer = Customer::find($customerId);
        if (!$customer) {
            return [ 'error' => 'Customer not found'];
        }
        return [
            'address' => $customer->address,
            'address_2' => $customer->address_2,
            'city' => $customer->city,
            'state' => $customer->state,
            'zip' => $customer->zip,
            'country_id' => $customer->country_id,
            'county' => $customer->county,
        ];
    }
}
