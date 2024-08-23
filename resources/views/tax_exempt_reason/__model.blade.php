<div class="modal fade" id="taxExemptReasonModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="taxExemptReasonForm" name="taxExemptReasonForm" class="form-horizontal">
                    <input type="hidden" name="tax_exempt_reason_id" id="tax_exempt_reason_id">
                    <div class="form-group mb-2 p-1">
                        <label for="reason" class="form-label pb-1">Reason <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter Reason" value="">
                        </div>
                        <span class="text-danger error-text reason_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showTaxExemptReasonModal" tabindex="-1" aria-labelledby="showTaxExemptReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Tax Exempt Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showTaxExemptReasonForm" name="showTaxExemptReasonForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="reason" class="form-label pb-1">Reason</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="reason" name="reason" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>