<?php

namespace App\Http\Controllers\SaleOrder;

use Exception;
use Illuminate\Http\Request;
use App\Models\SaleOrderLine;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SaleOrder\LineRepository;
use App\Http\Requests\SaleOrder\Line\CreateLineRequest;

class LineController extends Controller
{
    private LineRepository $lineRepository;
    public function __construct(LineRepository $lineRepository)
    {
        $this->lineRepository = $lineRepository;
    }

    public function store(CreateLineRequest $request)
    {
        try {
            $this->lineRepository->store($request->only('sales_order_id', 'item_id', 'so_line_no', 'item_description', 'quantity', 'unit_price', 'extended_amount', 'is_taxable', 'is_sold_as', 'is_hideon_print', 'line_item'));
            return response()->json(['status' => 'success', 'msg' => 'Service saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Service.']);
        }
    }

    public function edit($id)
    {
        $model = $this->lineRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->lineRepository->update($request->only('sales_order_id', 'item_id', 'so_line_no', 'item_description', 'quantity', 'unit_price', 'extended_amount', 'is_taxable', 'is_sold_as', 'is_hideon_print', 'line_item'), $id);
            return response()->json(['status' => 'success', 'msg' => 'Service updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Service: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Service.']);
        }
    }

    public function destroy($id)
    {
        try {
            $saleOrderService = $this->lineRepository->findOrFail($id);
            if ($saleOrderService) {
                $this->lineRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sales Order Service deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sales Order Service not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sales Order Service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sales Order Service.']);
        }
    }

    public function getAllProductDataTableList(Request $request)
    {
        return $this->lineRepository->dataTableGetProduct($request);
    }

    public function getLineDataTableList(Request $request, $id)
    {
        return $this->lineRepository->dataTable($request, $id);
    }
}
