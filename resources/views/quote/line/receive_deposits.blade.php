@extends('layouts.admin')

@section('title', 'Create Quote Receive Deposit')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 text-dark"><span class="text-primary">Quote Receive Deposit </h4>
        <div class="app-ecommerce">
            <!-- //Quote Details -->
            <form id="formAddQuoteReceiveDeposit">
                <!-- 1st row -->
                <div class="row mt-3">
                    <div class="col">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label">Customer</label>
                                        <input type="hidden" class="form-control" id="quote_id" name="quote_id" value="{{$quote->id}}">
                                        <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{$customer->id}}">
                                        <input type="text" class="form-control" readonly id="customer_name" name="customer_name" value="{{$customer->customer_name}}">
                                        <span class="text-danger error-text customer_id_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label">Transaction Location</label>
                                        <select class="form-select" id="location" name="location" disabled data-allow-clear="true">
                                            <option value="{{ $location->id }}">{{ $location    ->company_name }}</option>
                                        </select>
                                        <span class="text-danger error-text location_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label">Cash Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select bg-label-warning text-dark" id="cash_account_id" name="cash_account_id" style="pointer-events: none">
                                            <option value="">--select--</option>
                                            @foreach ($data['accounts'] as $account)
                                            <option value="{{$account->id}}" {{ isset($account) && $account->id == 1 ? 'selected' : '' }}>{{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text cash_account_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 2nd row -->
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-primary fw-bold"></span>
                                </h5>
                            </div>
                            <div class="card-body">

                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-6">
                                        <label>Address</label>
                                        <input type="type" class="form-control" id="address" name="address" placeholder="Enter Address">
                                        <span class="text-danger error-text address_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label>Suite</label>
                                        <input type="type" class="form-control" id="suite" name="suite" placeholder="Enter Suite">
                                        <span class="text-danger error-text suite_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label>City </label>
                                        <input type="type" class="form-control" id="city" name="city" placeholder="Enter City">
                                        <span class="text-danger error-text city_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-6">
                                        <label>State</label>
                                        <input type="type" class="form-control" id="state" name="state" placeholder="Enter State">
                                        <span class="text-danger error-text state_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label>Zip</label>
                                        <input type="type" class="form-control" id="zip" name="zip" placeholder="Enter Zip">
                                        <span class="text-danger error-text zip_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label>Memo</label>
                                        <input type="type" class="form-control" id="memo" name="memo" placeholder="Enter Memo">
                                        <span class="text-danger error-text memo_error"></span>
                                    </div>
                                </div>
                                <h5 class="mt-3">Miscellaneous</h5>
                                <div class="row mt-2">
                                    <div class="col-lg-3 col-sm-6">
                                        <label>Account</label>
                                        <select class="form-select" id="account_id" name="account_id">
                                            <option value="">--select--</option>
                                            @foreach ($data['accounts'] as $account)
                                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text account_id_error"></span>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label>Location</label>
                                        <select class="form-select" id="location_id" name="location_id">
                                            <option value="">--select--</option>
                                            @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text location_id_error"></span>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label>Description</label>
                                        <input type="type" class="form-control" id="description" name="description" placeholder="Enter Description">
                                        <span class="text-danger error-text description_error"></span>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label>Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount">
                                        <span class="text-danger error-text amount_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Internal Notes</label>
                                        <textarea type="type" class="form-control" id="internal_notes" name="internal_notes" placeholder="Enter Internal Notes"></textarea>
                                        <span class="text-danger error-text internal_notes_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Email Deposit as Confirmation</label>
                                        <textarea type="type" class="form-control" readonly id="email_deposit" name="email_deposit"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-1">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label">Receipt #</label>
                                        <input type="text" class="form-control" id="receipt_code" name="receipt_code">
                                        <span class="text-danger error-text receipt_code_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label">Deposit Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="deposit_date" name="deposit_date">
                                        <span class="text-danger error-text deposit_date_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <label class="form-label">Payment Method <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select" id="payment_method_id" name="payment_method_id">
                                            <option value="">--select--</option>
                                            @foreach ($data['paymentMethods'] as $id => $payment_method_name )
                                            <option value="{{$id}}">{{$payment_method_name}}</option>
                                            @endforeach
                                            <span class="text-danger error-text payment_method_id_error"></span>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-6 payment">
                                        <label class="form-label">Reference #</label>
                                        <input type="text" class="form-control" id="reference" name="reference">
                                        <span class="text-danger error-text reference_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 payment">
                                        <label class="form-label">Reference Date</label>
                                        <input type="date" class="form-control" id="reference_date" name="reference_date">
                                        <span class="text-danger error-text reference_date_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 payment">
                                        <label class="form-label">Authorization #</label>
                                        <input type="text" class="form-control" id="authorization" name="authorization">
                                        <span class="text-danger error-text authorization_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 payment d-none" id="check_code_container">
                                        <label class="form-label">Check # <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="check_code" required name="check_code">
                                        <span class="text-danger error-text check_code_error"></span>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 payment d-none" id="check_date_container">
                                        <label class="form-label">Check Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="check_date" required name="check_date">
                                        <span class="text-danger error-text check_date_error"></span>
                                    </div>
                                </div>


                                <h5 class="mt-3">
                                    Payment / Deposit for
                                </h5>
                                <div class="row p-2">
                                    <div class="col-lg-5 col-sm-6">
                                        <div class="row pt-2"><label class="text-dark fw-bold fs-6">Quote # {{$opportunity->opportunity_code}} - {{$quote->id}} - Total:</label></div>
                                        <div class="row pt-2"><label class="text-dark fw-bold fs-6">Current Balance Due:</label></div>
                                        <div class="row pt-2"><label class="text-dark fw-bold fs-6">Amount: <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label></div>
                                        <div class="row pt-2"><label class="text-dark fw-bold fs-6">Net Amount Due:</label></div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="row">
                                            <div class="d-flex gap-1">$<input type="text" class="form-control form-control-sm border-0 fs-6 fw-bold" id="quote_total" readonly value="{{$total}}"></div>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex gap-1">$<input type="text" class="form-control form-control-sm border-0 fs-6 fw-bold" id="current_balance_due" name="current_balance_due" value="{{$currentBalanceDue}}" readonly></div>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex gap-1">$<input type="number" class="form-control form-control-sm bg-label-warning text-dark fs-6 fw-bold" id="receive_amount" name="receive_amount"></div><span class="text-danger error-text receive_amount_error"></span>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex gap-1">$<input type="text" class="form-control form-control-sm border-0 fs-6 fw-bold" id="net_amount_due" name="net_amount_due" value="{{$currentBalanceDue}}" readonly></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="quotePercentage">% of Quote Amount:</label>
                                            <div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input quote_percentage" name="quote_amount_percentage" value="20"> 20%
                                                </label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input quote_percentage" name="quote_amount_percentage" value="25"> 25%
                                                </label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input quote_percentage" name="quote_amount_percentage" value="30"> 30%
                                                </label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input quote_percentage" name="quote_amount_percentage" value="40"> 40%
                                                </label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input quote_percentage" name="quote_amount_percentage" value="50"> 50%
                                                </label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input quote_percentage" name="quote_amount_percentage" value="100"> 100%
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <span class="text-primary fw-bold" id="word_amount"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3rd row -->

                <div class="row mt-2">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary me-lg-2" name="addNewDepositBtn" id="addNewDepositBtn">Add New Deposit</button>
                        <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('quote.line.__script_receive_deposit')
@endsection