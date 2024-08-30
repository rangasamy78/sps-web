<div class="modal fade" id="shipmentTermModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="shipmentTermForm" name="shipmentTermForm" class="form-horizontal">
                    <input type="hidden" name="shipment_term_id" id="shipment_term_id">
                    <div class="form-group mb-2 p-1">
                        <label for="shipment_term_name" class="col-sm-6 form-label pb-1">Shipment Term Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="shipment_term_name" name="shipment_term_name" placeholder="Enter Shipment Term Name" value="">
                        </div>
                        <span class="text-danger error-text shipment_term_name_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="description" class="col-sm-6 form-label pb-1">Description</label>
                        <div class="col-12">
                            <div id="descriptionEditor">&nbsp;</div>
                        </div>
                        <span class="text-danger error-text description_error"></span>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="description" name="description" rows="2" style="resize:none;display:none" placeholder="Enter Description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Shipment Term</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showShipmentTermModal" tabindex="-1" aria-labelledby="showShipmentTermModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Shipment Term</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showShipmentTermForm" name="showShipmentTermForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="shipment_term_name" class="form-label">Shipment Term Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="shipment_term_name" name="shipment_term_name" value="">
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="description" class="form-label pb-1">Description</label>
                        <div class="col-12">
                            <div id="showDescriptionEditor"></div>
                        </div>
                        <span class="text-danger error-text description_error"></span>
                        <textarea class="form-control" id="description" name="description" rows="2" style="resize:none;display:none"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
