<div class="modal fade" id="customerTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customerTypeForm" name="customerTypeForm" class="form-horizontal">
                    <input type="hidden" name="customer_type_id" id="customer_type_id">
                    <div class="form-group">
                        <label for="customer_type_name" class="form-label pb-1">Customer Type Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="customer_type_name" name="customer_type_name"
                                placeholder="Enter Customer Type Name" value="">
                        </div>
                        <span class="text-danger error-text customer_type_name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="customer_type_code" class="pb-1 form-label">Customer Type Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="customer_type_code" name="customer_type_code"
                                placeholder="Enter Customer Type Code" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Customer Type</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showCustomerTypeModal" tabindex="-1" aria-labelledby="show-customer-type-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-customer-type-modal-label">Show Customer Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showCustomerTypeForm" name="showCustomerTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label">Customer Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="customer_type_name" name="customer_type_name"
                                placeholder="Enter Customer Type Name" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="name" class="form-label">Customer Type Code</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="customer_type_code" name="customer_type_code"
                                placeholder="Enter Customer Type Code" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
