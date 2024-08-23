<div class="modal fade" id="productFinishModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productFinishForm" name="productFinishForm" class="form-horizontal">
                    <input type="hidden" name="product_finish_id" id="product_finish_id">
                    <div class="form-group">
                        <label for="Product Finish Code" class="col-sm-4 control-label">Product Finish Code <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_finish_code" name="product_finish_code"
                                placeholder="Enter Product Finish Code" value="">
                        </div>
                        <span class="text-danger error-text product_finish_code_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-2 control-label">Finish <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="finish" name="finish" placeholder="Enter Finish"
                                value="">
                        </div>
                        <span class="text-danger error-text finish_error"></span>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product Finish</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProductFinishModal" tabindex="-1" aria-labelledby="show-product-finish-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-finish-modal-label">Show Product Finish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductFinishForm" name="showProductFinishForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Product Finish Code" class="col-sm-4 control-label">Product Finish Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_finish_code" name="product_finish_code"
                                disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-2 control-label">Finish</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="finish" name="finish" disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>