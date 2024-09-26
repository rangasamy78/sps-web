<div class="modal fade" id="productKindModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productKindForm" name="productKindForm" class="form-horizontal">
                    <input type="hidden" name="product_kind_id" id="product_kind_id">
                    <div class="form-group mb-2 p-1">
                        <label for="product_kind_name" class="form-label pb-1">Kind Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_kind_name" name="product_kind_name" placeholder="Enter Kind Name" value="">
                        </div>
                        <span class="text-danger error-text product_kind_name_error"></span>
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
<div class="modal fade" id="showproductKindModal" tabindex="-1" aria-labelledby="showproductKindModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Product Kind</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showproductKindForm" name="showproductKindForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="product_kind_name" class="form-label pb-1">Kind Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="product_kind_name" name="product_kind_name">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>