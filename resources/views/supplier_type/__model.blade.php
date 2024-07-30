<div class="modal fade" id="supplierTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierTypeForm" name="supplierTypeForm" class="form-horizontal">
                    <input type="hidden" name="supplier_type_id" id="supplier_type_id">
                    <div class="form-group">
                        <label for="supplier-type-name" class="control-label">Supplier Type Name <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="supplier_type_name" name="supplier_type_name" placeholder="Enter Supplier Type Name" value="">
                        </div>
                        <span class="text-danger error-text supplier_type_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Supplier Type</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSupplierTypeModal" tabindex="-1" aria-labelledby="show-supplier-type-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-supplier-type-modal-label">Show Supplier Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSupplierTypeForm" name="showSupplierTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="supplier-type-name" class="control-label">Supplier Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="supplier_type_name" disabled name="supplier_type_name" placeholder="Enter Supplier Type Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
