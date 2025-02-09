<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Log;
use App\Models\InventoryAdjustmentReasonCode;
use App\Repositories\{ InventoryAdjustmentReasonCodeRepository, DropDownRepository };
use App\Http\Requests\InventoryAdjustmentReasonCode\{CreateInventoryAdjustmentReasonCodeRequest, UpdateInventoryAdjustmentReasonCodeRequest};

class InventoryAdjustmentReasonCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private InventoryAdjustmentReasonCodeRepository $inventoryAdjustmentReasonCodeRepository;
    public DropDownRepository $dropDownRepository;

    public function __construct(InventoryAdjustmentReasonCodeRepository $inventoryAdjustmentReasonCodeRepository,DropDownRepository $dropDownRepository)
    {
        $this->inventoryAdjustmentReasonCodeRepository = $inventoryAdjustmentReasonCodeRepository;
        $this->dropDownRepository = $dropDownRepository;
    }

    public function index()
    {
        $adjustment_types   = $this->dropDownRepository->dropDownPopulate('adjustment_types');
        $linked_accounts    = Account::query()->get();
        return view('inventory_adjustment_reason_code.inventory_adjustment_reason_codes', compact('adjustment_types','linked_accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateInventoryAdjustmentReasonCodeRequest $request)
    {
        try {
            $this->inventoryAdjustmentReasonCodeRepository->store($request->only('reason', 'adjustment_type_id', 'income_expense_account_id'));
            return response()->json(['status' => 'success', 'msg' => 'Inventory adjustment reason code saved successfully.']);
        } catch (Exception $e) {

            Log::error('Error saving inventory adjustment reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the inventory adjustment reason code.']);
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
        $model = $this->inventoryAdjustmentReasonCodeRepository->findOrFail($id);
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
        $model = $this->inventoryAdjustmentReasonCodeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryAdjustmentReasonCodeRequest $request, InventoryAdjustmentReasonCode $inventoryAdjustmentReasonCode)
    {
        try {
            $data = $request->only('reason', 'adjustment_type_id', 'income_expense_account_id');
            $this->inventoryAdjustmentReasonCodeRepository->update($data, $inventoryAdjustmentReasonCode->id);
            return response()->json(['status' => 'success', 'msg' => 'Inventory adjustment reason code updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating inventory adjustment reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the inventory adjustment reason code.']);
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
            $inventoryAdjustmentReasonCode = $this->inventoryAdjustmentReasonCodeRepository->findOrFail($id);
            if ($inventoryAdjustmentReasonCode) {
                $this->inventoryAdjustmentReasonCodeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Inventory adjustment reason code deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Inventory adjustment reason code not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting inventory adjustment reason code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the inventory adjustment reason Code.']);
        }
    }
    public function getInventoryAdjustmentReasonCodeLabelDataTableList(Request $request)
    {
        return $this->inventoryAdjustmentReasonCodeRepository->dataTable($request);
    }
}
