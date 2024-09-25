<div class="modal fade" id="specialAccountTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="specialAccountTypeForm" name="specialAccountTypeForm" class="form-horizontal">
                    <input type="hidden" name="special_account_type_id" id="special_account_type_id">
                    <div class="form-group mb-2 p-1">
                        <label for="product_kind_name" class="form-label pb-1">Special Account Type Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="special_account_type_name" name="special_account_type_name" placeholder="Enter Special Account Type Name" value="">
                        </div>
                        <span class="text-danger error-text special_account_type_name_error"></span>
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
<div class="modal fade" id="showSpecialAccountTypeModel" tabindex="-1" aria-labelledby="showSpecialAccountTypeModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Special Account Type Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showspecialAccountTypeForm" name="showspecialAccountTypeForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="special_account_type_name" class="form-label pb-1">Special Account Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="special_account_type_name" name="special_account_type_name">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>