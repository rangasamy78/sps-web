<div class="modal fade" id="subHeadingModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subHeadingForm" name="subHeadingForm" class="form-horizontal">
                    <input type="hidden" name="sub_heading_id" id="sub_heading_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-12 form-label">Sub Heading Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="sub_heading_name" name="sub_heading_name"
                                placeholder="Enter Sub Heading Name" value="">
                        </div>
                        <span class="text-danger error-text sub_heading_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Sub Heading</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSubHeadingModal" tabindex="-1" aria-labelledby="show-sub-heading-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-sub-heading-modal-label">Show Sub Heading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSubHeadingForm" name="showSubHeadingForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="sub_heading_name" class="col-sm-12 form-label">Sub Heading Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="sub_heading_name" name="sub_heading_name" placeholder="Enter Sub Heading Name">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
