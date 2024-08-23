<div class="modal fade" id="supplierCostListLabelModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierCostListLabelForm" name="supplierCostListLabelForm" class="form-horizontal">
                    <input type="hidden" name="supplier_cost_list_label_id" id="supplier_cost_list_label_id">
                    <div class="form-group mb-2 p-1">
                        <label for="cost_level" class="col-sm-6 control-label pb-1">Cost Level<sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cost_level" name="cost_level" placeholder="Enter Cost Level" value="">
                        </div>
                        <span class="text-danger error-text cost_level_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="cost_code" class="col-sm-6 control-label pb-1">Cost Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cost_code" name="cost_code" placeholder="Enter Cost Code" value="">
                        </div>
                        <span class="text-danger error-text cost_code_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="cost_label" class="col-sm-6 control-label pb-1">Cost Label<sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cost_label" name="cost_label" placeholder="Enter Cost Label" value="">
                        </div>
                        <span class="text-danger error-text cost_label_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSupplierCostListLabelModal" tabindex="-1" aria-labelledby="showSupplierCostListLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Supplier Cost List Label</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSupplierCostListLabelForm" name="showSupplierCostListLabelForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="cost_level" class="col-sm-6 control-label pb-1">Cost Level<sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="cost_level" name="cost_level" placeholder="Enter Cost Level" value="">
                        </div>
                        <span class="text-danger error-text cost_level_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="cost_code" class="col-sm-6 control-label pb-1">Cost Code<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="cost_code" name="cost_code" placeholder="Enter Cost Code" value="">
                        </div>
                        <span class="text-danger error-text cost_code_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="cost_label" class="col-sm-6 control-label pb-1">Cost Label<sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="cost_label" name="cost_label" placeholder="Enter Cost Label" value="">
                        </div>
                        <span class="text-danger error-text cost_label_error"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
