<?php

namespace App\Http\Controllers\Visit;

use Exception;
use App\Models\VisitFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Visit\VisitFileRepository;

class VisitFileController extends Controller
{
    private VisitFileRepository $visitFileRepository;
    public function __construct(VisitFileRepository $visitFileRepository)
    {
        $this->visitFileRepository = $visitFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->visitFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'visit_id'));
            return response()->json(['status' => 'success', 'msg' => 'Visit File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Visit File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Visit File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, VisitFile $visitFile)
    {
        try {
            $this->visitFileRepository->update($request->only('file_type_id', 'notes'), $visitFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Visit File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Visit File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Visit File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->visitFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->visitFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Visit File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Visit File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Visit File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Visit File.']);
        }
    }

    public function getVisitFileDataTableList(Request $request, $id)
    {
        return $this->visitFileRepository->dataTable($request, $id);
    }
}
