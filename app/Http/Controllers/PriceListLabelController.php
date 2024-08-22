<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Models\PriceListLabel;
use Illuminate\Support\Facades\Log;
use App\Repositories\PriceListLabelRepository;
use App\Http\Requests\PriceListLabel\{CreatePriceListLabelRequest, UpdatePriceListLabelRequest};

class PriceListLabelController extends Controller
{
    private PriceListLabelRepository $priceListLabelRepository;
    public function __construct(PriceListLabelRepository $priceListLabelRepository)
    {
        $this->priceListLabelRepository = $priceListLabelRepository;
    }
    public function index()
    {
        $countPriceListLabel = PriceListLabel::query()->select('id','price_level', 'price_code')->count();
        $customers = CustomerType::query()->select('id','customer_type_name', 'customer_type_code')->get();
        return view('price_list_label.price_list_labels', compact('customers', 'countPriceListLabel'));
    }
    public function store(CreatePriceListLabelRequest $request)
    {
        try {
            $this->priceListLabelRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Price list label saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving price list label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the price list label.']);
        }
    }
    public function show($id)
    {
        $model = $this->priceListLabelRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->priceListLabelRepository->findOrFail($id);
        return response()->json($model);
    }
    public function update(UpdatePriceListLabelRequest $request, PriceListLabel $priceListLabel)
    {
        try {
            $this->priceListLabelRepository->update($request->all(), $priceListLabel->id);
            return response()->json(['status' => 'success', 'msg' => 'Price list label updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating price list label: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the price list label.']);
        }
    }
    public function destroy($id)
    {
        try {
            $priceListLabel = $this->priceListLabelRepository->findOrFail($id);
            if ($priceListLabel) {
                $this->priceListLabelRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Price list label deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Price list label not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting price list label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the price list label.']);
        }
    }
    public function getPriceListLabelDataTableList(Request $request)
    {
        return $this->priceListLabelRepository->dataTable($request);
    }
}
