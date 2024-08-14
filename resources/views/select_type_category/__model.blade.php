<div class="modal fade" id="selectTypeCategoryModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="selectTypeCategoryForm" name="selectTypeCategoryForm" class="form-horizontal">
                    <input type="hidden" name="select_type_category_id" id="select_type_category_id">
                    <div class="form-group">
                        <label for="Select Type Category" class="col-sm-4 control-label">Select Type Category Name<sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="select_type_category_name" name="select_type_category_name" placeholder="Enter Select Type Category Name" value="">
                        </div>
                        <span class="text-danger error-text select_type_category_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Select Type Category</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSelectTypeCategoryModal" tabindex="-1" aria-labelledby="show-select-type-category-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-select-type-category-modal-label">Show Select Type Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSelectTypeCategoryForm" name="showselectTypeCategoryForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Select Type Category" class="col-sm-6 control-label">Select Type Category Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="select_type_category_name"
                                name="select_type_category_name" disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
