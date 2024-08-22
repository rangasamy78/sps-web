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
            return response()->json(['status' => 'success', 'msg' => 'Return reason code saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Return reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Return reason code.']);
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
            $this->returnReasonCodeRepository->update($request->only('return_code'), $returnReasonCode->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Return reason code Updated Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Return reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Return reason code.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $returnReasonCode = $this->returnReasonCodeRepository->findOrFail($id);
            if ($returnReasonCode) {
                $this->returnReasonCodeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Return reason code deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Return reason code not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Return reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Return reason code.']);
        }
    }

    public function getReturnReasonCodeDataTableList(Request $request) {
        return $this->returnReasonCodeRepository->dataTable($request);
    }
}
