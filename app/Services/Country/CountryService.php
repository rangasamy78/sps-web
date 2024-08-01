<?php

namespace App\Services\Country;

use App\Models\Country;

class CountryService
{
    public function getCountries()
    {
        return Country::query()->pluck('country_name','id');
    }

    public function getCountryNameById( $countryId ){

        $countryName = Country::query()
            ->where('id', $countryId)
            ->value('country_name');

        return $countryName;
    }

}
