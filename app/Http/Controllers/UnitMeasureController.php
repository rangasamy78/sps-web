<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\UnitMeasureRepository;
use App\Http\Requests\UnitMeasure\{CreateUnitMeasureRequest, UpdateUnitMeasureRequest};

class UnitMeasureController extends Controller
{
    private UnitMeasureRepository $unitMeasureRepository;

    public function __construct(UnitMeasureRepository $unitMeasureRepository)
    {
        $this->unitMeasureRepository = $unitMeasureRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unitMeasureOptions = UnitMeasure::getPredefinedUnitMeasureOptions();
        return view('unit_measure.unit_measures', compact('unitMeasureOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUnitMeasureRequest $request)
    {
        try {
            $this->unitMeasureRepository->store($request->only('unit_measure_entity', 'unit_measure_name'));
            return response()->json(['status' => 'success', 'msg' => 'Unit Measure saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Unit Measures: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Unit Measures.']);
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
        $model = $this->unitMeasureRepository->findOrFail($id);
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
        $model = $this->unitMeasureRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitMeasureRequest $request, UnitMeasure $unitMeasure)
    {
        try {
            $this->unitMeasureRepository->update($request->only('unit_measure_entity', 'unit_measure_name'), $unitMeasure->id);
            return response()->json(['status' => 'success', 'msg' => 'Unit Measure updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Unit Measure: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Unit Measure.']);
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
            $this->unitMeasureRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Unit Measure deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Unit Measure: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Unit Measure.']);
        }
    }

    public function getUnitMeasureDataTableList(Request $request)
    {
        return $this->unitMeasureRepository->dataTable($request);
    }
}