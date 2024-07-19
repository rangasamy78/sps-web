<div class="modal fade" id="productGroupModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productGroupForm" name="productGroupForm" class="form-horizontal">
                    <input type="hidden" name="product_group_id" id="product_group_id">
                    <!-- View In -->
                    <div class="form-group">
                        <label for="Product Finish Code" class="col-sm-4 control-label">Product Group Name <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_group_name" name="product_group_name"
                                placeholder="Enter Product Group Name" value="">
                        </div>
                        <span class="text-danger error-text product_group_name_error"></span>
                    </div>
                    <!-- File Type -->
                    <div class="form-group mt-3">
                        <label class="col-sm-4 control-label">Product Group Code </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_group_code" name="product_group_code"
                                placeholder="Enter Product Group Code" value="">
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product Group</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProductGroupModal" tabindex="-1" aria-labelledby="show-product-group-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-group-modal-label">Show Product Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductGroupForm" name="showProductGroupForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Group" class="col-sm-4 control-label">Product Group Name </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_group_name" name="product_group_name"
                                disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 control-label">Product Group Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_group_code" name="product_group_code"
                                disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>