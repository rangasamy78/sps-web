<?php

namespace App\Services\Expenditure;

use App\Models\Country;
use App\Models\Expenditure;
use App\Repositories\DropDownRepository;

class ExpenditureService
{
    public $dropDownRepository;

    public function __construct(DropDownRepository $dropDownRepository)
    {
        $this->dropDownRepository = $dropDownRepository;
    }

    public function getExpenditures()
    {
        return Expenditure::query()->pluck('customer_name','id');
    }

    public function getAllData()
    {
        return [
            'countries' => Country::query()->pluck('country_name','id'),
            'customers' => Expenditure::query()->pluck('customer_name','id'),
        ];
    }

    public function __formataddressParts($value)
    {
        $addressParts = [];
        $placeParts = [];
        if (!empty($value->internal_notes)) {
            $addressParts[] = $value->address;
        }
        if (!empty($value->city)) {
            $placeParts[] = $value->city;
        }
        if (!empty($value->state)) {
            $placeParts[] = $value->state;
        }
        if (!empty($value->zip)) {
            $placeParts[] = $value->zip;
        }
        if (!empty($placeParts)) {
            $address = implode(' ', $placeParts); // Create a single string separated by spaces
            $addressParts[] = $address;
        }
        if (!empty($value->county)) {
            $addressParts[] = $value->county;
        }
        return !empty($addressParts) ? implode('<br/>', $addressParts) : '';
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
