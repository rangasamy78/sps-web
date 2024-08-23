<div class="modal fade" id="productCategoryModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productCategoryForm" name="productCategoryForm" class="form-horizontal">
                    <input type="hidden" name="product_category_id" id="product_category_id">
                    <div class="form-group">
                        <label for="Category Name" class="col-sm-4 form-label">Category Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_category_name"
                                name="product_category_name" placeholder="Enter Category Name" value="">
                        </div>
                        <span class="text-danger error-text product_category_name_error"></span>
                    </div>
                    <div id="subcategory-container" class="col-sm-12 mt-3">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product
                    Category</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProductCategoryModal" tabindex="-1" aria-labelledby="show-product-category-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-product-category-modal-label">Show Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProductCategoryForm" name="showProductCategoryForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Category Name" class="col-sm-4 form-label">Category Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="product_category_name"
                                name="product_category_name" disabled value="">
                        </div>
                    </div>
                    <div id="subcategory-containers" class="col-sm-12 mt-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>