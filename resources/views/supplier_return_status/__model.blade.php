<div class="modal fade" id="supplierReturnStatusModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierReturnStatusForm" name="supplierReturnStatusForm" class="form-horizontal">
                    <input type="hidden" name="return_code_id" id="return_code_id">
                    <div class="form-group">
                        <label for="Return Code" class="col-sm-4 control-label">Return Code Name<sup
                                style="color: red;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="return_code_name" name="return_code_name"
                                placeholder="Enter Return Code Name" value="">
                        </div>
                        <span class="text-danger error-text return_code_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Return Code</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSupplierReturnStatusModal" tabindex="-1" aria-labelledby="show-return-code-name-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-return-code-name-modal-label">Show Return Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSupplierReturnStatusForm" name="showSupplierReturnStatusForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Return Code" class="col-sm-4 control-label">Return Code Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="return_code_name" name="return_code_name" disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




