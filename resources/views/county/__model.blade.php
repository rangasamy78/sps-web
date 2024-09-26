<div class="modal fade" id="countyModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countyForm" name="countyForm" class="form-horizontal">
                    <input type="hidden" name="county_id" id="county_id">
                    <div class="form-group">
                        <label for="county_name" class="form-label">County Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="county_name" name="county_name"
                                placeholder="Enter County Name" value="">
                        </div>
                        <span class="text-danger error-text county_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save County</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showCountymodal" tabindex="-1" aria-labelledby="show-county-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-county-modal-label">Show County</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showCountyForm" name="showCountyForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="county_name" class="form-label">County Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="county_name" name="county_name"
                                placeholder="" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
