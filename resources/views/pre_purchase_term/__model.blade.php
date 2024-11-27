<div class="modal fade" id="prePurchaseTermModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="prePurchaseTermForm" name="prePurchaseTermForm" class="form-horizontal">
                    <input type="hidden" name="pre_purchase_term_id" id="pre_purchase_term_id">
                    <div class="form-group">
                        <label for="pre_purchase_term_name" class="col-sm-6 form-label">Pre Purchase Term Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="pre_purchase_term_name" name="pre_purchase_term_name" placeholder="Enter Pre Purchase Term Name" value="">
                        </div>
                        <span class="text-danger error-text pre_purchase_term_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Pre Purchase Term</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showPrePurchaseTermModal" tabindex="-1" aria-labelledby="show-pre-purchase-term-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-pre-purchase-term-modal-label">Show Pre Purchase Term</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showPrePurchaseTermForm" name="showPrePurchaseTermForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 form-label">Pre Purchase Term Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="pre_purchase_term_name" name="pre_purchase_term_name" placeholder="Enter Pre Purchase Term Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
