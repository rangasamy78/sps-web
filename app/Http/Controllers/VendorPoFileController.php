<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\VendorPoFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\VendorPoFileRepository;

class VendorPoFileController extends Controller
{
    private VendorPoFileRepository $vendorPoFileRepository;
    public function __construct(VendorPoFileRepository $vendorPoFileRepository)
    {
        $this->vendorPoFileRepository = $vendorPoFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->vendorPoFileRepository->store($request->only('file_name', 'notes', 'vendor_po_id'));
            return response()->json(['status' => 'success', 'msg' => 'Vendor PO File Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Vendor PO File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Vendor PO File.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, VendorPoFile $vendorPoFile)
    {
        try {
            $this->vendorPoFileRepository->update($request->only('notes', ), $vendorPoFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Vendor File updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Vendor File: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Vendor File.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $vendorPoFile = $this->vendorPoFileRepository->findOrFail($id);
            if ($vendorPoFile) {
                $this->vendorPoFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Vendor File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Vendor File not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Vendor File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Vendor File.']);
        }
    }

    public function getVendorPoFileDataTableList(Request $request, $id)
    {
        return $this->vendorPoFileRepository->dataTable($request, $id);
    }
}