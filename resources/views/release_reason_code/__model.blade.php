<div class="modal fade" id="releaseReasonCodeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="releaseReasonCodeForm" name="releaseReasonCodeForm" class="form-horizontal">
                    <input type="hidden" name="return_code_id" id="return_code_id">
                    <div class="form-group">
                        <label for="Return Reason Code" class="col-sm-4 control-label">Return Reason Code <sup
                                style="color: red;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="return_code" name="return_code"
                                placeholder="Enter Return Reason Code" value="">
                        </div>
                        <span class="text-danger error-text return_code_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Return Reason Code</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showReleaseReasonCodeModal" tabindex="-1" aria-labelledby="show-release-reason-code-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-release-reason-code-modal-label">Show Release Reason Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showReturnReasonCodeForm" name="showReturnReasonCodeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Return Reason Code" class="col-sm-4 control-label">Return Reason Code</label>
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




