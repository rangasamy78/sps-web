<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\County;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\CountyRepository;
use App\Http\Requests\County\{CreateCountyRequest, UpdateCountyRequest};

class CountyController extends Controller
{
    private CountyRepository $countyRepository;

    public function __construct(CountyRepository $countyRepository)
    {
        $this->countyRepository = $countyRepository;
    }

    public function index()
    {
        return view('county.counties');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCountyRequest $request)
    {
        try {
            $this->countyRepository->store($request->only('county_name'));
            return response()->json(['status' => 'success', 'msg' => 'County saved successfully.'], 200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving county: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while saving the county.'], 500);
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
        $model = $this->countyRepository->findOrFail($id);
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
        $model = $this->countyRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountyRequest $request, County $county)
    {
        try {
            $this->countyRepository->update($request->only('county_name'), $county->id);
            return response()->json(['status' => 'success', 'msg' => 'County updated successfully.'],200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating county: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the county.'],500);
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
            $county = $this->countyRepository->findOrFail($id);
            if ($county) {
                $this->countyRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'County deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'County not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting county: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the county.']);
        }

    }

    public function getCountyDataTableList(Request $request)
    {
        return $this->countyRepository->dataTable($request);
    }

}
