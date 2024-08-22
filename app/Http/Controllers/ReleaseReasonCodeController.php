<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\ReleaseReasonCode;
use Illuminate\Support\Facades\Log;
use App\Repositories\ReleaseReasonCodeRepository;
use App\Http\Requests\ReleaseReasonCode\{CreateReleaseReasonCodeRequest, UpdateReleaseReasonCodeRequest};

class ReleaseReasonCodeController extends Controller
{
    private ReleaseReasonCodeRepository $releaseReasonCodeRepository;

    public function __construct(ReleaseReasonCodeRepository $releaseReasonCodeRepository)
    {
        $this->releaseReasonCodeRepository = $releaseReasonCodeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('release_reason_code.release_reason_codes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateReleaseReasonCodeRequest $request)
    {
        try {
            $this->releaseReasonCodeRepository->store($request->only('release_reason_code'));
            return response()->json(['status' => 'success', 'msg' => 'Release reason code saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving release reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the release reason code.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = $this->releaseReasonCodeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = $this->releaseReasonCodeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReleaseReasonCodeRequest $request, ReleaseReasonCode $releaseReasonCode)
    {
        try {
            $this->releaseReasonCodeRepository->update($request->only('release_reason_code'), $releaseReasonCode->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Release reason code Updated Successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating release reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Release reason code.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $releaseReasonCode = $this->releaseReasonCodeRepository->findOrFail($id);
            if ($releaseReasonCode) {
                $this->releaseReasonCodeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Release reason code deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Release reason code not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting release reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Release reason code.']);
        }
    }

    public function getReleaseReasonCodeDataTableList(Request $request) {
        return $this->releaseReasonCodeRepository->dataTable($request);
    }
}
