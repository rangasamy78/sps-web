<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\CountryRepository;
use App\Http\Requests\Country\{CreateCountryRequest, UpdateCountryRequest};

class CountryController extends Controller
{
    private CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index()
    {
        return view('country.countries');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCountryRequest $request)
    {
        try {
            $this->countryRepository->store($request->only('country_name','country_code','lead_time'));
            return response()->json(['status' => 'success', 'msg' => 'Country saved successfully.'], 200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving country: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while saving the country.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->countryRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->countryRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        try {
            $this->countryRepository->update($request->only('country_name','country_code','lead_time'), $country->id);
            return response()->json(['status' => 'success', 'msg' => 'Country updated successfully.'],200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating country: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the country.'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $country = $this->countryRepository->findOrFail($id);
            if ($country) {
                $this->countryRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Country deleted successfully.'],200);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Country not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting country: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the country.'],500);
        }
    }

    public function getCountryDataTableList(Request $request) {
        return $this->countryRepository->dataTable($request);
    }

}
