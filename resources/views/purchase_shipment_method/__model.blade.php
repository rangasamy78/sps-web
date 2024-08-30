<div class="modal fade" id="purchaseShipmentMethodModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="purchaseShipmentMethodForm" name="purchaseShipmentMethodForm" class="form-horizontal">
                    <input type="hidden" name="purchase_shipment_method_id" id="purchase_shipment_method_id">
                    <div class="form-group">
                        <label for="shipment_method_name" class="col-sm-6 form-label">Shipment Method Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="shipment_method_name" name="shipment_method_name" placeholder="Enter Shipment Method Name" value="">
                        </div>
                        <span class="text-danger error-text shipment_method_name_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="shipment_method_description" class="col-sm-6 form-label pb-1">Description</label>
                        <div class="col-12">
                            <div id="descriptionEditor">&nbsp;</div>
                        </div>
                        <span class="text-danger error-text shipment_method_description_error"></span>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="shipment_method_description" name="shipment_method_description" rows="2" style="resize:none;display:none" ></textarea>
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
<div class="modal fade" id="showPurchaseShipmentMethodModal" tabindex="-1" aria-labelledby="show-purchase-shipment-method-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-purchase-shipment-method-modal-label">Show Purchase Shipment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showPurchaseShipmentMethodForm" name="showPurchaseShipmentMethodForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 form-label">Shipment Method Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="shipment_method_name" name="shipment_method_name" placeholder="Enter Shipment Method Name" value="">
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="shipment_method_description" class="form-label pb-1">Description</label>
                        <div class="col-12">
                            <div id="showDescriptionEditor"></div>
                        </div>
                        <span class="text-danger error-text shipment_method_description_error"></span>
                        <textarea class="form-control" id="shipment_method_description" name="shipment_method_description" rows="2" style="resize:none;display:none"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
