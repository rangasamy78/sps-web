<div class="modal fade" id="accountTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accountTypeForm" name="accountTypeForm" class="form-horizontal">
                    <input type="hidden" name="account_type_id" id="account_type_id">
                    <div class="form-group">
                        <label for="account_type_name" class="col-sm-6 control-label">Account Type Name <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="account_type_name" name="account_type_name"
                                placeholder="Enter Account Type Name" value="">
                        </div>
                        <span class="text-danger error-text account_type_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save accountType</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showAccountTypemodal" tabindex="-1" aria-labelledby="show-account-type-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-account-type-modal-label">Show Account Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showAccountTypeForm" name="showAccountTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Account Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="account_type_name" name="account_type_name"
                                placeholder="Enter AccountType Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
