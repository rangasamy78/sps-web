<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\AdjustmentType;
use Illuminate\Support\Facades\Log;
use App\Repositories\AdjustmentTypeRepository;
use App\Http\Requests\AdjustmentType\{CreateAdjustmentTypeRequest, UpdateAdjustmentTypeRequest};

class AdjustmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private AdjustmentTypeRepository $adjustmentTypeRepository;

    public function __construct(AdjustmentTypeRepository $adjustmentTypeRepository)
    {
        $this->adjustmentTypeRepository = $adjustmentTypeRepository;
    }

    public function index()
    {
        return view('adjustment_type.adjustment_types');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateAdjustmentTypeRequest $request)
    {
        try {
            $this->adjustmentTypeRepository->store($request->only('adjustment_type'));
            return response()->json(['status' => 'success', 'msg' => 'Adjustment Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving adjustment type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the adjustment type.']);
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
        $model = $this->adjustmentTypeRepository->findOrFail($id);
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
        $model = $this->adjustmentTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdjustmentTypeRequest $request, AdjustmentType $adjustmentType)
    {
        try {
            $this->adjustmentTypeRepository->update($request->only('adjustment_type'), $adjustmentType->id);
            return response()->json(['status' => 'success', 'msg' => 'Adjustment Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Adjustment Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Adjustment Type.']);
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
            $this->adjustmentTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Adjustment Type deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Adjustment Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Adjustment Type.']);
        }
    }
    public function getAdjustmentTypeDataTableList(Request $request)
    {
        return $this->adjustmentTypeRepository->dataTable($request);
    }
}
