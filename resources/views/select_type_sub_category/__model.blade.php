<div class="modal fade" id="selectTypeSubCategoryModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="selectTypeSubCategoryForm" name="selectTypeSubCategoryForm" class="form-horizontal">
                    <input type="hidden" name="select_type_sub_category_id" id="select_type_sub_category_id">
                    <div class="form-group">
                        <label for="Select Type Sub Category" class="col-sm-4 control-label">Select Type Category Name<sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                        <select class="form-select select_type_category_id" name="select_type_category_id" id="select_type_category_id">
                                <option value="">--Select Type Category Name--</option>
                                @foreach($select_type_categories as $key => $select_type_category)
                                    <option value="{{ $key }}">{{ $select_type_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text select_type_category_id_error"></span>
                    </div>
                    <div id="subcategory-container" class="col-sm-12 mt-3">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Select Type Sub Category</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSelectTypeSubCategoryModal" tabindex="-1" aria-labelledby="show-select-type-sub-category-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-select-type-sub-category-modal-label">Show Select Type Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSelectTypeSubCategoryForm" name="showSelectTypeSubCategoryForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Select Type Sub Category" class="col-sm-8 control-label">Select Type  Category Name</label>
                        <div class="col-sm-12">
                        <select class="form-select select_type_category_id" disabled name="select_type_category_id" id="select_type_category_id">
                        <option value="">--Select Type Category--</option>
                            @foreach($select_type_categories as $key => $select_type_category)
                                    <option value="{{ $key }}">{{ $select_type_category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="subcategory-containers" class="col-sm-12 mt-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
