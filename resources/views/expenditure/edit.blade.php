@extends('layouts.admin')

@section('title', 'Non Inventory Expenditure')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Update Non Inventory Expenditure</h4>
        <form id="expenditureForm" name="expenditureForm" class="form-horizontal">
            <input type="hidden" name="expenditure_id" id="expenditure_id" value="{{$expenditure->id}}">
            <div class="app-ecommerce">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Expenditure information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="expenditure_name">Expenditure Name<sup style="color:red; font-size: 0.9rem;"><strong>*</strong>
                                        </label>
                                        <input type="text" class="form-control" id="expenditure_name"
                                            placeholder="Expenditure Name" name="expenditure_name"
                                            aria-label="Expenditure Name" value="{{$expenditure->expenditure_name}}"/>
                                        <span class="text-danger error-text expenditure_name_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="print_name">Print Name / DBA<sup style="color:red; font-size: 0.9rem;"><strong>*</strong> </label>
                                        <input type="text" class="form-control" id="print_name"
                                            placeholder="Print Name" name="print_name" aria-label="Print Name" value="{{$expenditure->print_name}}"/>
                                        <span class="text-danger error-text print_name_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="expenditure_code">Expenditure
                                            Code</label>
                                        <input type="text" class="form-control" id="expenditure_code"
                                            placeholder="Expenditure Code" name="expenditure_code"
                                            aria-label="Expenditure Code" value="{{$expenditure->expenditure_code}}"/>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="expenditure_type_id">Expenditure Type</label>
                                        <select id="expenditure_type_id" name="expenditure_type_id"
                                            class="select2 form-select" data-allow-clear="true">
                                            <option value="">--Select Expenditure Type--</option>
                                            @foreach ($vendor_types as $key => $value)
                                                <option value="{{ $key }}" {{ $key == old('expenditure_type_id', $expenditure->expenditure_type_id) ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label class="form-label" for="parent_location_id">Parent Location<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="parent_location_id" name="parent_location_id" class="select2 form-select"
                                            data-allow-clear="true">
                                            <option value="">--Select Parent Location--</option>
                                            @foreach ($company as $key => $value)
                                                <option value="{{ $key }}" {{ $key == old('parent_location_id', $expenditure->parent_location_id) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text parent_location_id_error"></span>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label" for="contact_name">Contact Name</label>
                                        <input type="text" class="form-control" id="contact_name"
                                            placeholder="Contact Name" name="contact_name" aria-label="Contact Name" value="{{$expenditure->contact_name}}" />
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label" for="since_date">Expenditure Since</label>
                                        <input type="date" class="form-control" id="since_date"
                                            placeholder="Since Date" name="since_date" aria-label="Since Date" value="{{ $expenditure->since_date ??  now()->format('Y-m-d') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-12 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Contact Information</h5>
                            </div>
                            <div class="card-body">
                                <form class="form-repeater">
                                    <div data-repeater-list="group-a">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="primary_phone">Primary Phone</label>
                                                    <input type="number" id="primary_phone" name="primary_phone" class="form-control"
                                                        placeholder="Enter Primary Phone" value="{{ $expenditure->primary_phone }}" />
                                                    <span class="text-danger error-text primary_phone_error"></span>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="secondary_phone">Secondary Phone</label>
                                                    <input type="number" id="secondary_phone" name="secondary_phone" class="form-control"
                                                        placeholder="Enter Secondary phone" value="{{$expenditure->secondary_phone}}" />
                                                    <span class="text-danger error-text secondary_phone_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="mobile">Mobile</label>
                                                    <input type="number" id="mobile" name="mobile" class="form-control"
                                                        placeholder="Enter Mobile" value="{{$expenditure->mobile}}" />
                                                    <span class="text-danger error-text mobile_error"></span>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="fax">Fax</label>
                                                    <input type="number" id="fax"  name="fax" class="form-control"
                                                        placeholder="Enter Fax" value="{{$expenditure->fax}}" />
                                                    <span class="text-danger error-text fax_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12">
                                                    <label class="form-label" for="email">Email Address</label>
                                                    <input type="text" id="email"  name="email" class="form-control"
                                                        placeholder="Enter Email" value="{{$expenditure->email}}" />
                                                    <span class="text-danger error-text email_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12">
                                                    <label class="form-label" for="website">Website</label>
                                                    <input type="text" id="website"  name="website" class="form-control"
                                                        placeholder="Enter Website" value="{{$expenditure->website}}" />
                                                    <span class="text-danger error-text website_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Remit-To Address</h5>
                            </div>
                            <div class="card-body">

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="address">address</label>
                                                <input type="text" id="address" name="address" class="form-control"
                                                    placeholder="Enter address" value="{{$expenditure->address}}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="suite">Suite / Unit#</label>
                                                <input type="text" id="suite" name="suite" class="form-control"
                                                    placeholder="Enter Suite / Unit#" value="{{$expenditure->suite}}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-8">
                                                <label class="form-label" for="city">City</label>
                                                <input type="text" id="city" name="city" class="form-control"
                                                    placeholder="Enter City" value="{{$expenditure->city}}"/>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="state">State</label>
                                                <input type="text" id="state" name="state" class="form-control"
                                                    placeholder="State" value="{{$expenditure->state}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="zip">Zip</label>
                                                <input type="text" id="zip" name="zip" class="form-control"
                                                    placeholder="Enter Zip" value="{{$expenditure->zip}}"/>
                                                <span class="text-danger error-text zip_error"></span>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="country_id">Country</label>
                                                <select name="country_id" id="country_id" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    <option value="">--Select Country--</option>
                                                    @foreach ($country as $key => $value)
                                                        <option value="{{ $key }}" {{ $key == old('country_id', $expenditure->country_id) ? 'selected' : ''}}>{{ $value }}</option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="shipping_address">address</label>
                                                <input type="text" id="shipping_address" name="shipping_address"  class="form-control"
                                                    placeholder="Enter address" value="{{$expenditure->zip}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="shipping_suite">Suite /
                                                    Unit#</label>
                                                <input type="text" id="shipping_suite"  name="shipping_suite" class="form-control" placeholder="Enter Suite / Unit#" value="{{$expenditure->shipping_suite}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-8">
                                                <label class="form-label" for="shipping_city">City</label>
                                                <input type="text" id="shipping_city" class="form-control"
                                                    placeholder="Enter City" value="{{$expenditure->shipping_city}}"/>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="shipping_state">State</label>
                                                <input type="text" id="shipping_state" name="shipping_state" class="form-control"
                                                    placeholder="State" value="{{$expenditure->shipping_state}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="shipping_zip">Zip</label>
                                                <input type="text" id="shipping_zip"  name="shipping_zip" class="form-control"
                                                    placeholder="Enter Zip" value="{{$expenditure->shipping_zip}}"/>
                                                <span class="text-danger error-text shipping_zip_error"></span>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="shipping_country_id">Country</label>
                                                <select id="shipping_country_id" name="shipping_country_id"  class="select2 form-select"
                                                    data-allow-clear="true">
                                                    <option value="">--Select Country--</option>
                                                    @foreach ($country as $key => $value)
                                                        <option value="{{ $key }}" {{ $key == old('shipping_country_id', $expenditure->shipping_country_id) ? 'selected' : ''}}>{{ $value }}</option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Accounting Information</h5>
                            </div>
                            <div class="card-body">

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="payment_terms">Payment
                                                    Terms</label>
                                                <select id="payment_terms"  name="payment_terms" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    <option value="">--Select Payment Term--</option>
                                                    @foreach ($account_payment_terms as $key => $value)
                                                        <option value="{{ $key }}" {{ $key == old('payment_terms', $expenditure->payment_terms) ? 'selected' : ''}}>{{ $value }}</option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="currency">Currency</label>
                                                <select id="currency_display"  name="currency_display" class="select2 form-select"
                                                    disabled="disabled">
                                                    <option value="USD" selected="selected">USD - USD</option>
                                                </select>
                                                <input type="hidden" name="currency" value="USD">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="expense_account_id">Default Expense
                                                    Account</label>
                                                <select id="expense_account_id" name="expense_account_id" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    <option value="">--Select Default Expense Account--</option>
                                                    @foreach($linked_accounts as $acc)
                                                        <option value="{{ $acc->id }}" 
                                                            {{ $acc->id == $expenditure->expense_account_id ? 'selected' : '' }}>
                                                            {{ $acc->account_number }} - {{ $acc->account_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-8">
                                                <label class="form-label" for="payment_method_id">Default Payment
                                                    Method</label>
                                                <select name="payment_method_id" id="payment_method_id" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    <option value="">--Select Payment Term--</option>
                                                    @foreach ($payment_methods as $key => $value)
                                                        <option value="{{ $key }}" {{ $key == old('payment_method_id', $expenditure->payment_method_id) ? 'selected' : ''}}>{{ $value }}</option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="account">Account #</label>
                                                <input type="text" id="account" name="account" class="form-control"
                                                    placeholder="Account" value="{{$expenditure->account}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="memo">Memo On Check</label>
                                                <input type="text" id="memo" name="memo" class="form-control"
                                                    placeholder="Enter Memo" value="{{$expenditure->memo}}"/>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="ein">Ein Number</label>
                                                <input type="number" id="ein" name="ein" class="form-control"
                                                    placeholder="Enter Ein" value="{{$expenditure->ein}}"/>
                                            </div>
                                            <div class="form-check pb-1">
                                                <label for="is_generic_expenditure"
                                                    class="form-check-label">Generic
                                                    Vendor </label>
                                                <input class="form-check-input" type="checkbox"
                                                    id="is_generic_expenditure"
                                                    name="is_generic_expenditure" value="1" {{ old('is_generic_expenditure', $expenditure->is_generic_expenditure == 1) ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3" style="margin-top: -2%;">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Vendor Login</h5>
                            </div>
                            <div class="card-body">
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="form-check pb-1">
                                                <input type="checkbox" class="form-check-input"
                                                    name="is_allow_login" id="is_allow_login" value="1" {{ old('is_allow_login', $expenditure->is_allow_login) ? 'checked' : '' }}>
                                                <label class="form-label" for="form-allow-login">Allow access to
                                                    Vendor
                                                    Login Module</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="expenditure_username">Username</label>
                                            </div>
                                            <div class="mb-3 col-8">
                                                <input type="text" id="expenditure_username" name="expenditure_username" class="form-control"
                                                    placeholder="Enter Username" value="{{$expenditure->expenditure_username}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="expenditure_password">Password</label>
                                            </div>
                                            <div class="mb-3 col-8">
                                                <input type="text" id="expenditure_password" name="expenditure_password" class="form-control"
                                                    placeholder="Enter Password" value="{{$expenditure->expenditure_password}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6" style="margin-top: -2%;">
                        <div class="card mb-4">
                            <div class="card-body">

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="form-check pb-1">
                                                <input type="checkbox" class="form-check-input"
                                                    name="is_print_1099" id="is_print_1099" value="1" {{ old('is_print_1099', $expenditure->is_print_1099) ? 'checked' : '' }}>
                                                <label class="form-label" for="is_print_1099">Form 1099 to be
                                                    printed for this vendor (Only U.S Vendors)</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-check pb-1">
                                                <input type="checkbox" class="form-check-input"
                                                    name="is_frieght_expenditure"
                                                    id="is_frieght_expenditure" value="1" {{ old('is_frieght_expenditure', $expenditure->is_frieght_expenditure) ? 'checked' : '' }}>
                                                <label class="form-label" for="is_frieght_expenditure">This
                                                    Vendor is a Freight Carrier; Bills from this Vendor get prorated
                                                    towards the Landed Cost of Inventory</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-check pb-1">
                                                <input type="checkbox" class="form-check-input"
                                                    name="is_sub_contractor" id="is_sub_contractor" value="1" {{ old('is_sub_contractor', $expenditure->is_sub_contractor) ? 'checked' : '' }}>
                                                <label class="form-label" for="is_sub_contractor">Bills from this
                                                    Vendor (Sub Contractor) are prorated towards job costing /
                                                    process costing</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Internal Notes</h5>
                            </div>
                            <div class="card-body">
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <textarea id="internal_notes" name="internal_notes" class="form-control">{{$expenditure->internal_notes}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 d-flex justify-content-center" style="margin-top: -2%;">
                        <button type="submit" class="btn btn-primary me-2" id="savedata" value="create">Update Expenditure</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@include('expenditure.__script')
@endsection
