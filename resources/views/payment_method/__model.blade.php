<div class="modal fade" id="paymentMethodModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentMethodForm" class="form-horizontal">
                    <input type="hidden" name="payment_method_id" id="payment_method_id">
                    <div class="form-group mb-3">
                        <label for="payment_method_name" class="col control-label pb-1">Payment Method Name<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="payment_method_name" name="payment_method_name" placeholder="Enter Payment Method Name" value="">
                        </div>
                        <span class="text-danger error-text payment_method_name_error"></span>
                    </div>
                    <div class="form-group pb-3">
                        <label for="linked_account_id" class="col control-label pb-1">Account</label>
                        <div class="col-sm-12">
                            <select class="form-select " name="linked_account_id" id="linked_account_id">
                                <option value="">--select here-- </option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                    <option value="{{ $linkedAccount['value'] }}" >{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text linked_account_id_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_type_id" class="col control-label pb-1">Account Type</label>
                        <div class="col-sm-12">
                            <select class="form-select " name="account_type_id" id="account_type_id">
                                <option value="">--select here--</option>
                                @foreach($data['accountTypes'] as $key => $accountType)
                                    <option value="{{ $accountType['value'] }}" >{{ $accountType['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text account_type_id_error"></span>
                    </div>
                    <div class="form-check pb-1">
                        <label for="is_transaction_required" class="form-check-label">Is Transaction# required while creating a Deposit/Payment</label>
                        <input class="form-check-input" type="checkbox" id="is_transaction_required" name="is_transaction_required" value="1">
                        <span class="text-danger error-text is_transaction_required_error"></span>
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


<div class="modal fade" id="showPaymentMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showPaymentMethodForm" name="showPaymentMethodForm" class="form-horizontal">
                    <div class="form-group mb-3">
                        <label for="payment_method_name" class="col control-label pb-1">Payment Method Name<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="payment_method_name" name="payment_method_name" placeholder="Enter Account Code" value="">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="linked_account_id" class="col control-label pb-1">Account</label>
                        <div class="col-sm-12">
                            <select class="form-select " disabled name="linked_account_id" id="linked_account_id">
                                <option value="">--select here--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                    <option value="{{ $linkedAccount['value'] }}" >{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_type" class="col control-label pb-1">Account Type</label>
                        <div class="col-sm-12">
                            <select class="form-select" disabled name="account_type_id" id="account_type_id">
                                <option value="">--select here--</option>
                                @foreach($data['accountTypes'] as $key => $accountType)
                                    <option value="{{ $accountType['value'] }}" >{{ $accountType['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-check">
                        <label for="is_transaction_required" class="form-check-label">Is Transaction# required while creating a Deposit/Payment</label>
                        <input class="form-check-input" type="checkbox" disabled id="is_transaction_required" name="is_transaction_required" value="Y">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>