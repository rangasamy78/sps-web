<div class="modal fade" id="vendorTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="vendorTypeForm" name="vendorTypeForm" class="form-horizontal">
                    <input type="hidden" name="vendor_type_id" id="vendor_type_id">
                    <div class="form-group">
                        <label for="vendor_type_name" class="col-sm-6 control-label">Vendor Type Name <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="vendor_type_name" name="vendor_type_name"
                                placeholder="Enter Vendor Type Name" value="">
                        </div>
                        <span class="text-danger error-text vendor_type_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Vendor Type</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showVendorTypeModal" tabindex="-1" aria-labelledby="show-vendor-type-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-vendor-type-modal-label">Show Vendor Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showVendorTypeForm" name="showVendorTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="vendor_type_name" class="col-sm-6 control-label">Vendor Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="vendor_type_name" name="vendor_type_name"
                                placeholder="Enter Vendor Type Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
