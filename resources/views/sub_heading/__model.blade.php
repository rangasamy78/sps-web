<div class="modal fade" id="subHeadingModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subHeadingForm" name="subHeadingForm" class="form-horizontal">
                    <input type="hidden" name="subheading_id" id="subheading_id">
                    <input type="hidden" name="set_as_default" id="set_as_default">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Sub Heading <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="sub_heading_name" name="sub_heading_name"
                                placeholder="Enter Sub Heading" value="">
                        </div>
                        <span class="text-danger error-text sub_heading_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Sub Heading</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showsubHeadingmodal" tabindex="-1" aria-labelledby="show-subheading-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-subheading-modal-label">Show Sub Heading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subHeadingShowForm" name="subHeadingShowForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="sub_heading_name" class="col-sm-4 control-label">Sub Heading Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="sub_heading_name" name="sub_heading_name"
                                placeholder="Enter Name" value="" >
                        </div>
                        <span class="text-danger error-text name_error"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
