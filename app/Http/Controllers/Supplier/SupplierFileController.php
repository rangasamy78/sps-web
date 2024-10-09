<?php

namespace App\Http\Controllers\Supplier;

use Exception;
use App\Models\SupplierFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Supplier\SupplierFileRepository;

class SupplierFileController extends Controller
{
    private SupplierFileRepository $supplierFileRepository;
    public function __construct(SupplierFileRepository $supplierFileRepository)
    {
        $this->supplierFileRepository = $supplierFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->supplierFileRepository->store($request->only('file_name', 'file_type_id', 'notes', 'supplier_id'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier File Uploaded successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving Supplier File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, SupplierFile $supplierFile)
    {
        try {
            $this->supplierFileRepository->update($request->only('file_type_id', 'notes'), $supplierFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Supplier File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Supplier File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $accountFile = $this->supplierFileRepository->findOrFail($id);
            if ($accountFile) {
                $this->supplierFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Supplier File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Supplier File.']);
        }
    }

    public function getSupplierFileDataTableList(Request $request, $id)
    {
        // dd($id);
        return $this->supplierFileRepository->dataTable($request, $id);
    }
}
