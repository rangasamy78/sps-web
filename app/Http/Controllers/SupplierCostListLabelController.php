<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SupplierCostListLabel;
use App\Repositories\SupplierCostListLabelRepository;
use App\Http\Requests\SupplierCostListLabel\{CreateSupplierCostListLabelRequest, UpdateSupplierCostListLabelRequest};

class SupplierCostListLabelController extends Controller
{
    private SupplierCostListLabelRepository $supplierCostListLabelRepository;

    public function __construct(SupplierCostListLabelRepository $supplierCostListLabelRepository)
    {
        $this->supplierCostListLabelRepository = $supplierCostListLabelRepository;
    }

    public function index()
    {
        return view('supplier_cost_list_label.supplier_cost_list_labels');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierCostListLabelRequest $request)
    {
        try {
            $this->supplierCostListLabelRepository->store($request->only('cost_level', 'cost_code', 'cost_label'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier cost list Label saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Supplier cost list Label : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier cost list Label .']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->supplierCostListLabelRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->supplierCostListLabelRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierCostListLabelRequest $request, SupplierCostListLabel $supplierCostListLabel)
    {
        try {
            $this->supplierCostListLabelRepository->update($request->only('cost_level', 'cost_code', 'cost_label'), $supplierCostListLabel->id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier cost list Label  updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Supplier cost list Label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier cost list Label.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $supplierCostListLabel = $this->supplierCostListLabelRepository->findOrFail($id);
            if ($supplierCostListLabel) {
                $this->supplierCostListLabelRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier cost list Label deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier cost list Label not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Supplier cost list Label: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Supplier cost list Label.']);
        }
    }

    public function getSupplierCostListLabelDataTableList(Request $request)
    {
        return $this->supplierCostListLabelRepository->dataTable($request);
    }
}
