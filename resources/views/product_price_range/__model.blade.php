<div class="modal fade" id="productPriceRangeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productPriceRangeForm" name="productPriceRangeForm" class="form-horizontal">
                    <input type="hidden" name="product_price_range_id" id="product_price_range_id">
                    <div class="form-group">
                        <label for="Product Price Range" class="col-sm-4 form-label">Product Price Range <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_price_range" name="product_price_range"
                                placeholder="Enter Product Price Range" value="">
                        </div>
                        <span class="text-danger error-text product_price_range_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product Price Range </button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProductPriceRangeModal" tabindex="-1" aria-labelledby="show-product-price-range-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-price-range-modal-label">Show Product Price Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductPriceRangeForm" name="showProductPriceRangeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Product Price Range" class="col-sm-4 form-label">Product Price Range</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_price_range" name="product_price_range" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




