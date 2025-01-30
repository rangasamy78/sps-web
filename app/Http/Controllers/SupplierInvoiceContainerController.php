<?php

    namespace App\Http\Controllers;
    
    use App\Http\Controllers\Controller;
    use App\Models\SupplierInvoiceContainer;
    use App\Repositories\SupplierInvoiceContainerRepository;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    
    class SupplierInvoiceContainerController extends Controller
    {
        private SupplierInvoiceContainerRepository $supplierInvoiceContainerRepository;
        public function __construct(SupplierInvoiceContainerRepository $supplierInvoiceContainerRepository)
        {
            $this->supplierInvoiceContainerRepository = $supplierInvoiceContainerRepository;
        }
    
        public function store(Request $request)
        {
           
            try {
                $this->supplierInvoiceContainerRepository->store($request->only('container_number', 'received_on', 'received_by','notes','po_id'));
                return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice Uploaded successfully.']);
            } catch (Exception $e) {
                Log::error('Error saving Supplier Invoice: ' . $e->getMessage());
                return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Invoice.', 'error' => $e->getMessage()]);
            }
        }
    
        public function update(Request $request, SupplierInvoiceContainer $supplierInvoiceContainer)
        {
            try {
                $this->supplierInvoiceContainerRepository->update($request->only('notes', ), $supplierInvoiceContainer->id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice updated successfully.']);
            } catch (Exception $e) {
                Log::error('Error updating Supplier Invoice: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Supplier Invoice.']);
            }
        }
    
        public function destroy(string $id)
        {
            try {
                $supplierInvoiceContainer = $this->supplierInvoiceContainerRepository->findOrFail($id);
                if ($supplierInvoiceContainer) {
                    $this->supplierInvoiceContainerRepository->delete($id);
                    return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice Container deleted successfully.']);
                } else {
                    return response()->json(['status' => 'false', 'msg' => 'Supplier Invoice not found.']);
                }
            } catch (Exception $e) {
                Log::error('Error deleting Supplier Invoice: ' . $e->getMessage());
                return response()->json(['status' => 'false', 'msg' => 'An error occuredr while deleting the Supplier Invoice.']);
            }
        }
    
        public function getSupplierInvoiceContainerDataTableList(Request $request)
        {
            return $this->supplierInvoiceContainerRepository->dataTable($request);
        }
        public function FetchSupplierSlabData($id)
        {
            $freight = $this->supplierInvoiceContainerRepository->dataSupplierSlabDataDetails($id);
          
            if ($freight) {
                return response()->json([
                    'success' => true,
                    'data'    => $freight,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Service not found',
                ]);
            }
        }
    }
    