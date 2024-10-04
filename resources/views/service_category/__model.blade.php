<div class="modal fade" id="serviceCategoryModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="serviceCategoryForm"  class="form-horizontal">
                    <input type="hidden" name="service_category_id" id="service_category_id">
                    <div class="form-group">
                    <label for="name" class="form-label pb-1">Service Category <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup>
                    </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="service_category" name="service_category" placeholder="Enter Service Category" value="">
                        </div>
                        <span class="text-danger error-text service_category_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" name="savedata" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showServiceCategoryModal" tabindex="-1" aria-labelledby="showServiceCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showServiceCategoryModalLabel">Show Service Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showServiceCategoryForm" name="showServiceCategoryForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label pb-2">Service Category</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="service_category" name="service_category" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
