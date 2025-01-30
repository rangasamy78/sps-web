<div class="modal fade" id="inventoryAdjustmentReasonCodeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="inventoryAdjustmentReasonCodeForm" name="inventoryAdjustmentReasonCodeForm" class="form-horizontal">
                    <input type="hidden" name="inventory_adjustment_reason_code_id" id="inventory_adjustment_reason_code_id">
                    <div class="form-group">
                        <label for="Reason" class="pb-1 form-label">Reason <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="reason" name="reason"
                                placeholder="Enter Reason" value="">
                        </div>
                        <span class="text-danger error-text reason_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Adjustment Type <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select class="form-control select2" id="adjustment_type_id" name="adjustment_type_id" data-allow-clear="true">
                                <option value="">--Select Adjustment Type--</option>
                                @foreach($adjustment_types as $key => $adjustment_type)
                                <option value="{{ $key }}">{{ $adjustment_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text adjustment_type_id_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Income Expense Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select id="income_expense_account_id" class="form-select select2" name="income_expense_account_id" data-allow-clear="true">
                                <option value="">--Select Income Expense Account--</option>
                             
                                @foreach($linked_accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text income_expense_account_id_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Inventory Adjustment Reason Code</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showInventoryAdjustmentReasonCodeModal" tabindex="-1" aria-labelledby="show-inventory-adjustment-reason-code-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-inventory-adjustment-reason-code-modal-label">Show Inventory Adjustment Reason Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showInventoryAdjustmentReasonCodeForm" name="showInventoryAdjustmentReasonCodeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Reason" class="form-label">Reason </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="reason" disabled name="reason"
                                placeholder="Enter Reason" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Adjustment Type</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="adjustment_type_id" disabled name="adjustment_type_id">
                                <option value="">--Select Adjustment Type--</option>
                                @foreach($adjustment_types as $key => $adjustment_type)
                                <option value="{{ $key }}">{{ $adjustment_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Income Expense Account</label>
                        <div class="col-sm-12">
                            <select id="income_expense_account_id" class="form-select" disabled name="income_expense_account_id">
                                @foreach($linked_accounts as $key => $linkedAccount)
                                    <option value="{{ $linkedAccount['value'] }}">{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
