<div class="modal fade" id="termTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="termTypeForm" name="termTypeForm" class="form-horizontal">
                    <input type="hidden" name="term_type_id" id="term_type_id">
                    <div class="form-group">
                        <label for="term_type_name" class="form-label">Term Type Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="term_type_name" name="term_type_name"
                                placeholder="Enter Term Type Name" value="">
                        </div>
                        <span class="text-danger error-text term_type_name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="term_type_name" class="form-label">Type Name<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select name="type_id" id="type_id" class="form-control">
                                <option value="">Select Type</option>
                                <option value="1">Standard</option>
                                <option value="2">Date driven</option>
                            </select>
                        </div>
                        <span class="text-danger error-text type_id_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save termType</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showTermTypemodal" tabindex="-1" aria-labelledby="show-account-type-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-account-type-modal-label">Show Term Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showTermTypeForm" name="showTermTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label">Term Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="term_type_name" name="term_type_name"
                                placeholder="Enter TermType Name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Type Name</label>
                        <div class="col-sm-12">
                            <select name="type_id" id="type_id" class="form-control" disabled>
                                <option value="">Select Type</option>
                                <option value="1">Standard</option>
                                <option value="2">Date driven</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
