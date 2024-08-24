<div class="modal fade" id="calculateMeasurementLabelModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="calculateMeasurementLabelForm" name="calculateMeasurementLabelForm" class="form-horizontal">
                    <input type="hidden" name="label_name_id" id="label_name_id">
                    <div class="form-group">
                        <label for="Calculate Measurement Label" class="form-label">Label Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="label_name" name="label_name"
                                placeholder="Enter Label Name" value="">
                        </div>
                        <span class="text-danger error-text label_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Calculate Measurement Label</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showCalculateMeasurementLabelModal" tabindex="-1" aria-labelledby="show-label_name-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-label_name-modal-label">Show Calculate Measurement Label</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showCalculateMeasurementLabelForm" name="showCalculateMeasurementLabelForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Calculate Measurement Label" class="form-label">Label Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="label_name" name="label_name" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
