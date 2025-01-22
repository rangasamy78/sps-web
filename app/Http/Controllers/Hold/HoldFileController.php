<?php

namespace App\Http\Controllers\Hold;

use Exception;
use App\Models\HoldFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Hold\HoldFileRepository;

class HoldFileController extends Controller
{
    private HoldFileRepository $holdFileRepository;
    public function __construct(HoldFileRepository $holdFileRepository)
    {
        $this->holdFileRepository = $holdFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->holdFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'hold_id'));
            return response()->json(['status' => 'success', 'msg' => 'Hold File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Hold File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Hold File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, HoldFile $holdFile)
    {
        try {
            $this->holdFileRepository->update($request->only('file_type_id', 'notes'), $holdFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Hold File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Hold File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Hold File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->holdFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->holdFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Hold File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Hold File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Hold File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Hold File.']);
        }
    }

    public function getHoldFileDataTableList(Request $request, $id)
    {
        return $this->holdFileRepository->dataTable($request, $id);
    }
}
