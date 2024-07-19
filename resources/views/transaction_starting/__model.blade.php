<div class="modal fade" id="transactionStartingModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transactionStartingForm" name="transactionStartingForm" class="form-horizontal">
                    <input type="hidden" name="transaction_starting_id" id="transaction_starting_id">

                    <div class="form-group">
                        <label for="Type" class="col-sm-4 control-label">Type <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="type" name="type" placeholder="Enter Type"
                                value="">
                        </div>
                        <span class="text-danger error-text type_error"></span>
                    </div>

                    <div class="form-group mt-3">
                        <label class="col-sm-4 control-label">Starting Number <sup
                                style="color: red;font-size:1rem;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="starting_number" name="starting_number"
                                placeholder="Enter Starting Number" value="">
                        </div>
                        <span class="text-danger error-text starting_number_error"></span>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Transaction Starting
                    Number</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showTransactionStartingModal" tabindex="-1"
    aria-labelledby="show-transaction-starting-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-transaction-starting-modal-label">Show Transaction Starting Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showTransactionStartingForm" name="showTransactionStartingForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Type" class="col-sm-4 control-label">Type</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="type" name="type" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 control-label">Starting Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="starting_number" name="starting_number" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>