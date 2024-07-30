<div class="modal fade" id="adjustmentTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adjustmentTypeForm" name="adjustmentTypeForm" class="form-horizontal">
                    <input type="hidden" name="adjustment_type_id" id="adjustment_type_id">
                    <div class="form-group">
                        <label for="Adjustment Type" class="col-sm-4 control-label">Adjustment Type <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="adjustment_type" name="adjustment_type"
                                placeholder="Enter Adjustment Type" value="">
                        </div>
                        <span class="text-danger error-text adjustment_type_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Adjustment Type</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showAdjustmentTypeModal" tabindex="-1" aria-labelledby="show-adjustment-type-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-adjustment-type-modal-label">Show Adjustment Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showAdjustmentTypeForm" name="showAdjustmentTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Adjustment Type" class="col-sm-4 control-label">Adjustment Type</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="adjustment_type" name="adjustment_type" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




