<?php

namespace App\Http\Controllers\Opportunity;

use Exception;
use Illuminate\Http\Request;
use App\Models\OpportunityFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Opportunity\OpportunityFileRepository;

class OpportunityFileController extends Controller
{
    private OpportunityFileRepository $opportunityFileRepository;
    public function __construct(OpportunityFileRepository $opportunityFileRepository)
    {
        $this->opportunityFileRepository = $opportunityFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->opportunityFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'opportunity_id'));
            return response()->json(['status' => 'success', 'msg' => 'Opportunity File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Opportunity File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Opportunity File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, OpportunityFile $opportunityFile)
    {
        try {
            $this->opportunityFileRepository->update($request->only('file_type_id', 'notes'), $opportunityFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Opportunity File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Opportunity File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Opportunity File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->opportunityFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->opportunityFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Opportunity File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Opportunity File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Opportunity File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Opportunity File.']);
        }
    }

    public function getOpportunityFileDataTableList(Request $request, $id)
    {
        return $this->opportunityFileRepository->dataTable($request, $id);
    }
}
