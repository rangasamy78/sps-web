<div class="modal fade" id="releaseReasonCodeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="releaseReasonCodeForm" name="releaseReasonCodeForm" class="form-horizontal">
                    <input type="hidden" name="release_reason_code_id" id="release_reason_code_id">
                    <div class="form-group">
                        <label for="Release Reason Code" class="col-sm-4 form-label">Release Reason Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="release_reason_code" name="release_reason_code"
                                placeholder="Enter Release Reason Code" value="">
                        </div>
                        <span class="text-danger error-text release_reason_code_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Release Reason Code</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
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
                <form id="showReleaseReasonCodeForm" name="showReleaseReasonCodeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Release Reason Code" class="col-sm-4 form-label">Release Reason Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="release_reason_code" name="release_reason_code" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




