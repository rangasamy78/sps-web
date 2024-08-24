<div class="modal fade" id="shipmentMethodModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="shipmentMethodForm" name="shipmentMethodForm" class="form-horizontal">
                    <input type="hidden" name="shipment_method_id" id="shipment_method_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 form-label">Shipment Method Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="shipment_method_name" name="shipment_method_name"
                                placeholder="Enter Shipment Method Name" value="">
                        </div>
                        <span class="text-danger error-text shipment_method_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Shipment Method</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showShipmentMethodModal" tabindex="-1" aria-labelledby="show-shipment-method-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-shipment-method-modal-label">Show Shipment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showShipmentMethodForm" name="showShipmentMethodForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 form-label">Shipment Method Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="shipment_method_name" name="shipment_method_name"
                                placeholder="Enter Shipment Method Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
