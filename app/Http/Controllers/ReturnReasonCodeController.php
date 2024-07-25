<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\ReturnReasonCode;
use Illuminate\Support\Facades\Log;
use App\Repositories\ReturnReasonCodeRepository;
use App\Http\Requests\ReturnReasonCode\{CreateReturnReasonCodeRequest, UpdateReturnReasonCodeRequest};

class ReturnReasonCodeController extends Controller
{
    private ReturnReasonCodeRepository $returnReasonCodeRepository;

    public function __construct(ReturnReasonCodeRepository $returnReasonCodeRepository)
    {
        $this->returnReasonCodeRepository = $returnReasonCodeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('return_reason_code.return_reason_codes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateReturnReasonCodeRequest $request)
    {
        try {
            $this->returnReasonCodeRepository->store($request->only('return_code'));
            return response()->json(['status' => 'success', 'msg' => 'Return Reason Code saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Return Reason Code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Return Reason Code.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = $this->returnReasonCodeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = $this->returnReasonCodeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReturnReasonCodeRequest $request, ReturnReasonCode $returnReasonCode)
    {
        try {
            $this->returnReasonCodeRepository->update($request->only('return_reason_code'), $returnReasonCode->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Return Reason Code Updated Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Return Reason Code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Return Reason Code.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->returnReasonCodeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Return Reason Code deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Return Reason Code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Return Reason Code.']);
        }
    }

    public function getReturnReasonCodeDataTableList(Request $request) {
        return $this->returnReasonCodeRepository->dataTable($request);
    }
}
