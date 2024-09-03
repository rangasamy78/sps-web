<div class="modal fade" id="accountPaymentTermModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accountPaymentTermForm" name="accountPaymentTermForm" class="form-horizontal">
                    <input type="hidden" name="account_payment_term_id" id="account_payment_term_id">
                    <div class="form-group">
                        <label for="name" class="form-label pb-1">Payment Code</label>
                        <div class="col-sm-12 mb-3">
                            <input type="text" class="form-control" id="payment_code" name="payment_code" placeholder="Enter Code" value="">
                        </div>
                        <span class="text-danger error-text payment_code_error"></span>
                        <label for="name" class="form-label pb-1">Payment Label<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12 mb-3">
                            <input type="text" class="form-control" id="payment_label" name="payment_label" placeholder="Enter label" value="">
                            <span class="text-danger error-text payment_label_error"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_type" class="form-label">Payment Type<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <select class="form-select select2" name="payment_type" id="payment_type" data-allow-clear="true">
                                        @foreach($account_types as $key => $account_type)
                                        <option value="{{ $account_type['value'] }}">{{ $account_type['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text payment_type_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_net_due_day" class="form-label"><span id="payment_net_due_day_label">Net Days to Pay</span> <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                    <input type="text" class="form-control" id="payment_net_due_day" name="payment_net_due_day" placeholder="Enter Day" value="">
                                    <span class="text-danger error-text payment_net_due_day_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="payemnt_discount_display">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_discount_percent" class="form-label">Discount %</label>
                                    <input type="text" class="form-control" id="payment_discount_percent" name="payment_discount_percent" placeholder="Enter Discount %" value="">
                                    <span class="text-danger error-text payment_discount_percent_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_threshold_days" class="form-label">Discount Threshold Days</label>
                                    <input type="text" class="form-control" id="payment_threshold_days" name="payment_threshold_days" placeholder="Enter Discount Threshold Days" value="">
                                    <span class="text-danger error-text payment_threshold_days_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="payment_not_used_sales" name="payment_not_used_sales">
                                    <label for="payment_not_used_sales"> Not Used In Sales</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="payment_not_used_purchases" name="payment_not_used_purchases">
                                    <label for="payment_not_used_purchases"> Not Used In Purchases</label>
                                </div>
                            </div>
                        </div>
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
<div class="modal fade" id="showAccountPaymentTermModal" tabindex="-1" aria-labelledby="showAccountPaymentTermModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showAccountPaymentTermModalLabel">Show Payment Term</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showAccountPaymentTermForm" name="showAccountPaymentTermForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label">Payment Code</label>
                        <div class="col-sm-12 mb-3">
                            <input type="text" disabled class="form-control" id="payment_code" name="payment_code" value="">
                        </div>
                        <label for="name" class="form-label pb-1">Payment Label</label>
                        <div class="col-sm-12 mb-3">
                            <input type="text" disabled class="form-control" id="payment_label" name="payment_label" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="payment_type" class="form-label">Payment Type</label>
                                <select disabled class="form-select" name="payment_type" id="payment_type">
                                    <option value="">Select Payment Type</option>
                                    @foreach($account_types as $key => $account_type)
                                    <option value="{{ $account_type['value'] }}">{{ $account_type['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="payment_net_due_day" class="form-label" id="show_payment_net_due_day_label">Net Days to Pay </sup></label>
                                <input disabled type="text" class="form-control" id="payment_net_due_day" name="payment_net_due_day" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="show_payemnt_discount_display">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="payment_discount_percent" class="form-label">Discount %</label>
                                <input disabled type="text" class="form-control" id="payment_discount_percent" name="payment_discount_percent" value="">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="payment_threshold_days" class="form-label">Discount Threshold Days</label>
                                <input disabled type="text" class="form-control" id="payment_threshold_days" name="payment_threshold_days" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input disabled class="form-check-input" type="checkbox" value="1" id="payment_not_used_sales" name="payment_not_used_sales">
                                <label for="payment_not_used_sales"> Not Used In Sales</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input disabled class="form-check-input" type="checkbox" value="1" id="payment_not_used_purchases" name="payment_not_used_purchases">
                                <label for="payment_not_used_purchases"> Not Used In Purchases</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>