<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\EndUseSegment;
use Illuminate\Support\Facades\Log;
use App\Repositories\EndUseSegmentRepository;
use App\Http\Requests\EndUseSegment\{CreateEndUseSegmentRequest, UpdateEndUseSegmentRequest};


class EndUseSegmentController extends Controller
{
    private EndUseSegmentRepository $endUseSegmentRepository;
    public function __construct(EndUseSegmentRepository $endUseSegmentRepository)
    {
        $this->endUseSegmentRepository = $endUseSegmentRepository;
    }
    public function index()
    {
        return view('end_use_segment.end_use_segments');
    }
    public function store(CreateEndUseSegmentRequest $request)
    {
        try {
            $endUseSegments = $this->endUseSegmentRepository->store($request->only('end_use_segment'));
            return response()->json(['status' => 'success', 'msg' => 'End use segment saved successfully.', 'data' => $endUseSegments]);
        } catch (Exception $e) {
            Log::error('Error saving end use segment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the end use segment.']);
        }
    }
    public function show($id)
    {
        $model = $this->endUseSegmentRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->endUseSegmentRepository->findOrFail($id);
        return response()->json($model);
    }
    public function update(UpdateEndUseSegmentRequest $request, EndUseSegment $endUseSegment)
    {
        try {
            $this->endUseSegmentRepository->update($request->only('end_use_segment'), $endUseSegment->id);
            return response()->json(['status' => 'success', 'msg' => 'End use segment updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating end use segment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the end use segment.']);
        }
    }

    public function destroy($id)
    {
        try {
            $endUseSegment = $this->endUseSegmentRepository->findOrFail($id);
            if ($endUseSegment) {
                $this->endUseSegmentRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'End use segment deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'End use segment not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting end use segment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the end use segment.']);
        }
    }
    public function getEndUseSegementDataTableList(Request $request)
    {
        return $this->endUseSegmentRepository->dataTable($request);
    }
}
