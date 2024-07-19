<div class="modal fade" id="productColorModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productColorForm" name="productColorForm" class="form-horizontal">
                    <input type="hidden" name="product_color_id" id="product_color_id">
                    <div class="form-group">
                        <label for="Product Color" class="col-sm-4 control-label">Product Color <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_color" name="product_color"
                                placeholder="Enter Product Color" value="">
                        </div>
                        <span class="text-danger error-text product_color_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product Color</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProductColorModal" tabindex="-1" aria-labelledby="show-product-color-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-color-modal-label">Show Product Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductColorForm" name="showProductColorForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Product Color" class="col-sm-4 control-label">Product Color</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_color" name="product_color" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




