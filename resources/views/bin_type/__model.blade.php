<div class="modal fade" id="binTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="binTypeForm"  class="form-horizontal">
                    <input type="hidden" name="bintype_id" id="bintype_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Bin Type <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="bin_type" name="bin_type" placeholder="Enter Bin Type" value="">
                        </div>
                        <span class="text-danger error-text bin_type_error"></span>
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


<div class="modal fade" id="show-binType-modal" tabindex="-1" aria-labelledby="show-binType-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-binType-modal-label">Show Bin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="binTypeShowForm" name="binTypeShowForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Bin Type</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="bin_type" name="bin_type" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>