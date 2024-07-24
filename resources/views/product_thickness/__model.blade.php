<div class="modal fade" id="productThicknessModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productThicknessForm" name="productThicknessForm" class="form-horizontal">
                    <input type="hidden" name="product_thickness_id" id="product_thickness_id">
                    <div class="form-group">
                    <div class="row mb-3">
                        <label for="name" class="control-label">Product Thickness Name<sup style="color: red;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_thickness_name" name="product_thickness_name"
                                placeholder="Enter Product Thickness Name" value="">
                        </div>
                        <span class="text-danger error-text product_thickness_name_error"></span>
                    </div>
                    
                    <div class="row">
                        <label for="name" class="control-label">Product Thickness Unit <sup style="color: red;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_thickness_unit" name="product_thickness_unit"
                                placeholder="Enter Product Thickness Unit" value="">
                        </div>
                        <span class="text-danger error-text product_thickness_unit_error"></span>
                    </div>    
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product Thickness</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showProductThicknessModal" tabindex="-1" aria-labelledby="show-product-thickness-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-thickness-modal-label">Show Product Thickness</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductThicknessForm" name="showProductThicknessForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="product_thickness_name" class="col-sm-6 control-label">Product Thickness Name</label>
                        <div class="col-sm-12  mb-3">
                            <input type="text" disabled class="form-control" id="product_thickness_name" name="product_thickness_name" value="" >
                        </div>
                        <label for="product_thickness_unit" class="col-sm-6 control-label">Product Thickness Unit</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="product_thickness_unit" name="product_thickness_unit" value="" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
