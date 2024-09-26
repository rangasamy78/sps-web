<div class="tab-pane fade" id="price_sheet" role="tabpanel">
    <h5>Price Sheet</h5>
    <table class="datatables-basic table table-striped" id="supplierPriceSheet">
        <thead class="table-header-bold">
            <tr>
                <th>Item (SKU)</th>
                <th>Effective Dt. - Expiry Dt.</th>
                <th>Purchase Name (SKU)</th>
                <th>Cost</th>
                <th>Remarks</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<form name="savePriceSheetForm" id="savePriceSheetForm">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasPriceSheet"
        aria-labelledby="offcanvasEndLabel">

        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Add New Supplier Price</h5>
            <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto">
            <div class="form-group mb-3">
                <label for="contact_name" class="form-label">Item<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="contact_name" name="contact_name"
                        placeholder="Enter Contact Name" value="">
                </div>
                <span class="text-danger error-text contact_name_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="title" class="form-label">Effective Date</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="title" name="title"
                        placeholder="Enter Title" value="">
                </div>
                <span class="text-danger error-text title_error"></span>
            </div>

            <div class="form-group mb-3">
                <label for="address" class="form-label">Expiry Date</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="address" name="address"
                        placeholder="Enter Address" value="">
                </div>
                <span class="text-danger error-text address_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="address_2" class="form-label">Purchase AS Name</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="address_2" name="address_2"
                        placeholder="Enter Address 2" value="">
                </div>
                <span class="text-danger error-text address_2_error"></span>
            </div>
            <div class="form-group mb-3">
                <label for="state" class="form-label">Purchase AS SKU</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="state" name="state"
                        placeholder="Enter State" value="">
                </div>
                <span class="text-danger error-text state_error"></span>
            </div>
            <div class="form-group mb-3 row">
                <div class="col-12">
                    <label for="city" class="form-label">Cost</label>
                    <input type="text" class="form-control" id="city" name="city"
                        placeholder="Enter City" value="">
                    <span class="text-danger error-text state_error"></span>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="internal_notes" class="form-label">Remarks</label>
                <div class="col-sm-12">
                    <textarea id="internal_notes" name="internal_notes" class="form-control" rows="2" placeholder="Enter Internal Notes" style="resize:none"></textarea>
                </div>
                <span class="text-danger error-text internal_notes_error"></span>
            </div>
            <div class="row">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="savePricedata" name="savecontactdata">Save</button>
                    <button type="button" class="btn btn-label-secondary ms-2" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>

    </div>
</form>