<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CalculateMeasurementLabel;
use App\Repositories\CalculateMeasurementLabelRepository;
use App\Http\Requests\CalculateMeasurementLabel\{CreateCalculateMeasurementLabelRequest, UpdateCalculateMeasurementLabelRequest};

class CalculateMeasurementLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private CalculateMeasurementLabelRepository $calculateMeasurementLabelRepository;

    public function __construct(CalculateMeasurementLabelRepository $calculateMeasurementLabelRepository)
    {
        $this->calculateMeasurementLabelRepository = $calculateMeasurementLabelRepository;
    }

    public function index()
    {
        return view('calculate_measurement_label.calculate_measurement_labels');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateCalculateMeasurementLabelRequest $request)
    {
        try {
            $this->calculateMeasurementLabelRepository->store($request->only('label_name'));
            return response()->json(['status' => 'success', 'msg' => 'Calculate measurement label saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving calculate measurement label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the calculate measurement label.']);
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
        $model = $this->calculateMeasurementLabelRepository->findOrFail($id);
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
        $model = $this->calculateMeasurementLabelRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalculateMeasurementLabelRequest $request, CalculateMeasurementLabel $calculateMeasurementLabel)
    {
        try {
            $this->calculateMeasurementLabelRepository->update($request->only('label_name'), $calculateMeasurementLabel->id);
            return response()->json(['status' => 'success', 'msg' => 'Calculate measurement label updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating calculate measurement label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the calculate measurement label.']);
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
            $calculateMeasurementLabel = $this->calculateMeasurementLabelRepository->findOrFail($id);
            if ($calculateMeasurementLabel) {
                $this->calculateMeasurementLabelRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Calculate measurement label deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Calculate measurement label not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting calculate measurement label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the calculate measurement label.']);
        }
    }
    public function getCalculateMeasurementLabelDataTableList(Request $request)
    {
        return $this->calculateMeasurementLabelRepository->dataTable($request);
    }
}
