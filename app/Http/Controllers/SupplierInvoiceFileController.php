<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SupplierInvoiceFile;
use App\Repositories\SupplierInvoiceFileRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierInvoiceFileController extends Controller
{
    private SupplierInvoiceFileRepository $supplierInvoiceFileRepository;
    public function __construct(SupplierInvoiceFileRepository $supplierInvoiceFileRepository)
    {
        $this->supplierInvoiceFileRepository = $supplierInvoiceFileRepository;
    }

    public function store(Request $request)
    {
        try {
            $this->supplierInvoiceFileRepository->store($request->only('file_name', 'notes', 'po_id'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice Uploaded successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Supplier Invoice: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Invoice.', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, SupplierInvoiceFile $supplierInvoiceFile)
    {
        try {
            $this->supplierInvoiceFileRepository->update($request->only('notes', ), $supplierInvoiceFile->id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Supplier Invoice: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Supplier Invoice.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $supplierInvoiceFile = $this->supplierInvoiceFileRepository->findOrFail($id);
            if ($supplierInvoiceFile) {
                $this->supplierInvoiceFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier Invoice not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Supplier Invoice: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Supplier Invoice.']);
        }
    }

    public function getSupplierInvoiceFileDataTableList(Request $request)
    {
        return $this->supplierInvoiceFileRepository->dataTable($request);
    }
}
