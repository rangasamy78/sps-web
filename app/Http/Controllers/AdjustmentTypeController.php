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
            return response()->json(['status' => 'success', 'msg' => 'Adjustment type saved successfully.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Adjustment type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating adjustment type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the adjustment type.']);
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
            $adjustmentType = $this->adjustmentTypeRepository->findOrFail($id);
            if ($adjustmentType) {
                $response = $this->adjustmentTypeRepository->delete($id);
                $data     = $response->getData();
                if ($data->status == 'success') {
                    return response()->json(['status' => $data->status, 'msg' => $data->msg]);
                } elseif ($data->status == 'error') {
                    return response()->json(['status' => $data->status, 'msg' => $data->msg]);
                }
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Adjustment type not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Adjustment type : ' . $e->getMessage());
            return response()->json(['status' => $data->status, 'msg' => $data->msg], 500);
        }
        return $response;
    }

    public function getAdjustmentTypeDataTableList(Request $request)
    {
        return $this->adjustmentTypeRepository->dataTable($request);
    }
}
