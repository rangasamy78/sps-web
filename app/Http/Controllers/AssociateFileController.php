<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssociateFile;
use App\Repositories\AssociateFileRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssociateFileController extends Controller
{
    private AssociateFileRepository $associateFileRepository;
    public function __construct(AssociateFileRepository $associateFileRepository)
    {
        $this->associateFileRepository = $associateFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->associateFileRepository->store($request->only('file_name', 'notes', 'associate_id'));
            return response()->json(['status' => 'success', 'msg' => 'Associate File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Associate File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Associate File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, AssociateFile $associateFile)
    {
        try {
            $this->associateFileRepository->update($request->only('notes', ), $associateFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Associate File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Associate File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Associate File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $associateFile = $this->associateFileRepository->findOrFail($id);
            if ($associateFile) {
                $this->associateFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Associate File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Associate File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Associate File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Associate File.']);
        }
    }

    public function getAssociateFileDataTableList(Request $request)
    {
        return $this->associateFileRepository->dataTable($request);
    }
}
