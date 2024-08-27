<div class="modal fade" id="accountSubTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accountSubTypeForm" name="accountSubTypeForm" class="form-horizontal">
                    <input type="hidden" name="account_sub_type_id" id="account_sub_type_id">
                    <div class="form-group mb-2 p-1">
                        <label for="sub_type_name" class="form-label pb-1">Sub Type Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="sub_type_name" name="sub_type_name" placeholder="Enter Sub Type Name" value="">
                        </div>
                        <span class="text-danger error-text sub_type_name_error"></span>
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
<div class="modal fade" id="showAccountSubTypeModal" tabindex="-1" aria-labelledby="showAccountSubTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Account Sub Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showAccountSubTypeForm" name="showAccountSubTypeForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="sub_type_name" class="form-label pb-1">Sub Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="sub_type_name" name="sub_type_name" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
