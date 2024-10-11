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

    public function __formatPhoneParts($value)
    {
        $phoneParts = [];
        if (!empty($value->phone)) {
            $phoneParts[] = 'P: ' . $value->phone;
        }
        // if (!empty($value->phone_2)) {
        //     $phoneParts[] = 'P1: ' . $value->phone_2;
        // }
        // if (!empty($value->fax)) {
        //     $phoneParts[] = 'F: ' . $value->fax;
        // }
        // if (!empty($value->mobile)) {
        //     $phoneParts[] = 'M: ' . $value->mobile;
        // }
        if (!empty($value->email)) {
            $phoneParts[] = 'E: ' . $value->email;
        }
        // if (!empty($value->accounting_email)) {
        //     $phoneParts[] = 'A.E: ' . $value->accounting_email;
        // }
        return !empty($phoneParts) ? implode('<br>', $phoneParts) : '';
    }

    public function __formatCustomerParts($value)
    {
        $customerParts = [];
        if (!empty($value->customer_name)) {
            $customerParts[] = $value->customer_name;
        }
        // if (!empty($value->print_name)) {
        //     $customerParts[] = 'DBA: ' . $value->print_name;
        // }
        // if (!empty($value->contact_name)) {
        //     $customerParts[] = 'C: ' . $value->contact_name;
        // }

        return !empty($customerParts) ? implode('<br>', $customerParts) : '';
    }

    public function __formatSalesPersonParts($value)
    {
        $salesPersonParts = [];
        if (!empty($value->sales_person)) {
            $salesPersonParts[] = $value->sales_person->full_name."<sup>1</sup>";
        }
        // if (!empty($value->secondary_sales_person)) {
        //     $salesPersonParts[] = $value->secondary_sales_person->full_name."<sup>2</sup>";
        // }

        return !empty($salesPersonParts) ? implode('<br>', $salesPersonParts) : '';
    }

    public function __formataddressParts($value)
    {
        $addressParts = [];
        // $placeParts = [];
        // if (!empty($value->internal_notes)) {
        //     $addressParts[] = $value->address;
        // }
        // if (!empty($value->city)) {
        //     $placeParts[] = $value->city;
        // }
        if (!empty($value->state)) {
            $addressParts[] = $value->state;
        }
        // if (!empty($value->zip)) {
        //     $placeParts[] = $value->zip;
        // }
        // if (!empty($placeParts)) {
        //     $address = implode(' ', $placeParts); // Create a single string separated by spaces
        //     $addressParts[] = $address;
        // }
        if (!empty($value->county)) {
            $addressParts[] = $value->county;
        }
        return !empty($addressParts) ? implode('<br/>', $addressParts) : '';
    }

    public function __formatImageNoteParts($value)
    {
        $imageNoteParts = [];
        if (!empty($value->internal_notes)) {
            $imageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\internal_notes.png') . '" width="20" height="20" alt="Image" title="'.$value->internal_notes.'">';
        }
        if (!empty($value->delivery_instructions)) {
            $imageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\icon_freight.gif') . '" width="20" height="20" alt="Image" title="'.$value->delivery_instructions.'">';
        }
        if (!empty($value->sales_lock_note)) {
            $imageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\icon_lockAlert.gif') . '" width="20" height="20" alt="Image" title="'.$value->sales_lock_note.'">';
        }
        return !empty($imageNoteParts) ? implode(' ', $imageNoteParts) : '';
    }

    public function __formatContactImageNoteParts($value)
    {
        $contactImageNoteParts = [];
        if (!empty($value->is_ship_to_address)) {
            $contactImageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\icon_shiptodefault.png') . '" alt="Image" >';
        }
        return !empty($contactImageNoteParts) ? implode(' ', $contactImageNoteParts) : '';
    }
}
