<?php

namespace App\Http\Controllers\SampleOrder;

use Exception;
use Illuminate\Http\Request;
use App\Models\SampleOrderFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SampleOrder\SampleOrderFileRepository;

class SampleOrderFileController extends Controller
{
    private SampleOrderFileRepository $sampleOrderFileRepository;
    public function __construct(SampleOrderFileRepository $sampleOrderFileRepository)
    {
        $this->sampleOrderFileRepository = $sampleOrderFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->sampleOrderFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'sample_order_id'));
            return response()->json(['status' => 'success', 'msg' => 'Sample Order File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Sample Order File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Sample Order File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, SampleOrderFile $sampleOrderFile)
    {
        try {
            $this->sampleOrderFileRepository->update($request->only('file_type_id', 'notes'), $sampleOrderFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Sample Order File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Sample Order File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Sample Order File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->sampleOrderFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->sampleOrderFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sample Order File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sample Order File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sample Order File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Sample Order File.']);
        }
    }

    public function getSampleOrderFileDataTableList(Request $request, $id)
    {
        return $this->sampleOrderFileRepository->dataTable($request, $id);
    }
}
