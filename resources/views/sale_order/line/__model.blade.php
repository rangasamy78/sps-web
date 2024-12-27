<div class="modal fade" id="serviceModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="stateForm" name="stateForm" class="form-horizontal">
                    <input type="hidden" name="state_id" id="state_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 form-label">Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name" value="">
                        </div>
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-2 form-label">Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Enter code" value="">
                        </div>
                        <span class="text-danger error-text code_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save State</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
