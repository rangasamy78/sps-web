<div class="modal fade" id="returnReasonCodeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="returnReasonCodeForm" name="returnReasonCodeForm" class="form-horizontal">
                    <input type="hidden" name="return_code_id" id="return_code_id">
                    <div class="form-group">
                        <label for="Return Code" class="col-sm-4 control-label">Return Code <sup
                                style="color: red;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="return_code" name="return_code"
                                placeholder="Enter Return Code" value="">
                        </div>
                        <span class="text-danger error-text return_code_error"></span>
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
<div class="modal fade" id="showReturnReasonCodeModal" tabindex="-1" aria-labelledby="show-return-code-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-return-code-modal-label">Show Return Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showReturnReasonCodeForm" name="showReturnReasonCodeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Return Code" class="col-sm-4 control-label">Return Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="return_code" name="return_code" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




