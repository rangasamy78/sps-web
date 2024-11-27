@extends('layouts.admin')

@section('title', 'Add Vendor Po')

@section('styles')
<style>
.suggestion-item {
    cursor: pointer;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <form id="vendorPoPaymentForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="app-ecommerce">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Make Payment</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Vendor">Vendor <sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="hidden" class="form-control" id="vendor_po_id" name="vendor_po_id"
                                            value="{{$vendor_po->id}}">
                                        <input type="hidden" class="form-control" id="vendor_po_total"
                                            name="vendor_po_total" value="{{$vendor_po->extended_total}}">
                                        <input type="hidden" class="form-control" id="net_amount_due"
                                            name="net_amount_due" value="{{$vendor_po->extended_total}}">
                                        <input type="text" class="form-control" id="vendor_id" name="vendor_id"
                                            aria-label="Vendor"
                                            value="{{$vendor_po->vendor->expenditure_name ?? ''}}" />
                                        <span class="text-danger error-text vendor_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Cash Account">Cash Account
                                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="cash_account_id" id="cash_account_id"
                                            data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            @foreach ($linked_accounts as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == $vendor_po->vendor->expense_account_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text cash_account_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Payment Date">Payment Date <sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="payment_date" name="payment_date"
                                            aria-label="Payment Date" value="{{ now()->format('Y-m-d') }}" />

                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Payment Method">Payment Method
                                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="payment_method_id"
                                            id="payment_method_id" data-allow-clear="true">

                                            @foreach ($payment_methods as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == $vendor_po->vendor->payment_method_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach


                                        </select>
                                        <span class="text-danger error-text payment_method_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Check #">Check #<sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="check" name="check"
                                            aria-label="Check #" />
                                    </div>
                                    <span class="text-danger error-text check_error"></span><br><br>
                                    <div class="col">
                                        <label class="form-label" for="Date on Check">Date on Check<sup
                                                style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="date_on_check" name="date_on_check"
                                            aria-label="Date on Check" value="{{ now()->format('Y-m-d') }}" />
                                        <span class="text-danger error-text date_on_check_error"></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Address">Address</label>
                                        <input class="form-control" id="address" name="address" aria-label="Address"
                                            value="{{$vendor_po->address ?? ''}}" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Suite">Suite</label>
                                        <input type="text" class="form-control" id="suite" name="suite"
                                            aria-label="Suite" value="{{$vendor_po->vendor->suite ?? ''}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2">
                                        <label class="form-label" for="City">City </label>
                                        <input type="text" class="form-control" id="city" name="city" aria-label="City"
                                            value="{{$vendor_po->city ?? ''}}">

                                    </div>
                                    <div class="col-2">
                                        <label class="form-label" for="State">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                            aria-label="State" value="{{$vendor_po->state ?? ''}}">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label" for="Zip">Zip</label>
                                        <input type="text" class="form-control" id="zip" name="zip" aria-label="Zip"
                                            value="{{$vendor_po->zip ?? ''}}">

                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Memo">Memo</label>
                                        <input type="text" class="form-control" id="memo" name="memo" aria-label="Memo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Prepayment for</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div>
                                                <label class="form-label fw-bold" for="vendor_po_total">VendorPO
                                                    #{{$vendor_po->transaction_number ?? ''}} - Total:</label><br>
                                            </div>
                                            <div>
                                                <label class="form-label fw-bold" style="color: #7eb3e3;"
                                                    for="vendor_po_total">Balance Due:</label><br>
                                            </div>
                                            <div>
                                                <label class="form-label fw-bold"
                                                    for="vendor_po_total">Amount:</label><br>
                                            </div>
                                            <div>
                                                <label class="form-label fw-bold" style="color: #7eb3e3;"
                                                    for="vendor_po_total">Net Amount Due:</label><br>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-label"><span
                                                            id="extended_total">${{ number_format($vendor_po->extended_total ?? 0, 2) }}</span></label>

                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Balance
                                                        Due:${{ number_format($vendor_po->extended_total ?? 0, 2) }}</label>

                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="amount" value="0.00" class="form-control"
                                                        id="amount" style="height: 25px;">
                                                    <span class="text-danger error-text amount_error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Net Amount Due: $<span
                                                            id="extended_net_total">{{ $vendor_po->extended_total ?? '' }}</span></label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div>
                                            <label class="form-label">% of PO Amount:</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="po_percentage" value="20" id="po_percentage_20">
                                            <label class="form-check-label" for="po_percentage_20">20%</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="po_percentage" value="25" id="po_percentage_25">
                                            <label class="form-check-label" for="po_percentage_25">25%</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="po_percentage" value="30" id="po_percentage_30">
                                            <label class="form-check-label" for="po_percentage_30">30%</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="po_percentage" value="35" id="po_percentage_35">
                                            <label class="form-check-label" for="po_percentage_35">35%</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Miscellaneous</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="address">Account</label>
                                        <select class="form-select select2" name="account_id" id="account_id"
                                            data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            @foreach ($linked_accounts as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="Description">Description</label>
                                        <input type="text" class="form-control" id="description"
                                            placeholder="Enter Description" name="description"
                                            aria-label="Description" />

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="City">Amount</label>
                                        <input type="text" class="form-control" id="misc_amount"
                                            placeholder="Enter Amount" name="misc_amount" aria-label="amount" />


                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="fax">Internal Notes</label>
                                        <textarea class="form-control" id="internal_notes"
                                            placeholder="Enter Internal Notes" name="internal_notes"
                                            aria-label="Internal Notes"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="savedataPayment"
                            name="savedataPayment">Save & View Payment</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton"
                            name="cancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </form>
</div>

@endsection
@section('scripts')

@include('vendor_po.pre_payment.__scripts')

@endsection