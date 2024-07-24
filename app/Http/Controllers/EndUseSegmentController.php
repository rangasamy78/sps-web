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
            return response()->json(['status' => 'success', 'msg' => 'End Use Segment saved successfully.', 'data' => $endUseSegments]);
        } catch (Exception $e) {
            Log::error('Error saving End Use Segment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the End Use Segment.']);
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
            return response()->json(['status' => 'success', 'msg' => 'End Use Segment updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating End Use Segment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the End Use Segment.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->endUseSegmentRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'End Use Segment deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting End Use Segment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the End Use Segment.']);
        }
    }
    public function getEndUseSegementDataTableList(Request $request)
    {
        return $this->endUseSegmentRepository->dataTable($request);
    }
}
