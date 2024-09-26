@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <form id="supplierEditForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Supplier /</span><span> Edit Supplier</span></h4>
            <div class="app-ecommerce">
                <div class="row">
                    <!-- First column-->
                    <div class="col-12 col-lg-7">
                        <!-- Product Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Supplier Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" id="supplier_id" name="supplier_id" value="{{$supplier->id}}">
                                        <label class="form-label" for="supplier_name">Supplier Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="supplier_name"
                                            placeholder="Enter Supplier Name"
                                            name="supplier_name"
                                            aria-label="Supplier Name" value="{{$supplier->supplier_name}}" />
                                        <span class="text-danger error-text supplier_name_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="code">Code</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="code"
                                            placeholder="Enter Code"
                                            name="code"
                                            aria-label="Code" value="{{$supplier->code}}" />
                                        <span class="text-danger error-text code_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="print_name">Print Name / DBA <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="print_name"
                                            placeholder="Enter Print Name"
                                            name="print_name"
                                            aria-label="Print Name" value="{{$supplier->print_name}}" />
                                        <span class="text-danger error-text print_name_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="contact_name">Contact Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="contact_name"
                                            placeholder="Enter Contact Name"
                                            name="contact_name"
                                            aria-label="Contact Name" value="{{$supplier->contact_name}}" />
                                        <span class="text-danger error-text contact_name_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="supplier_type_id">Supplier Type</label>
                                        <select id="supplier_type_id" name="supplier_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($supplierTypes as $supplierType)
                                            <option value="{{ $supplierType->id }}" {{ isset($supplier) && $supplier->supplier_type_id == $supplierType->id ? 'selected' : '' }}>{{ $supplierType->supplier_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text supplier_type_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="language_id">language_id</label>
                                        <select id="language_id" name="language_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ isset($supplier) && $supplier->language_id == $language->id ? 'selected' : '' }}>{{ $language->language_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text language_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="parent_location_id">Parent Location <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="parent_location_id" name="parent_location_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ isset($supplier) && $supplier->parent_location_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text parent_location_id_error"></span>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="parent_supplier_id">Parent Supplier</label>
                                        <select id="parent_supplier_id" name="parent_supplier_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($allSuppliers as $allSupplier)
                                            <option value="{{ $allSupplier->id }}" {{ isset($supplier) && $supplier->parent_supplier_id == $allSupplier->id ? 'selected' : '' }}>{{ $allSupplier->supplier_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text parent_supplier_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label class="form-label" for="supplier_since">Supplier Since</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="supplier_since"
                                            name="supplier_since"
                                            aria-label="Supplier Since" value="{{$supplier->supplier_since}}" />
                                        <span class="text-danger error-text supplier_since_error"></span>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label" for="supplier_port_id">Port</label>
                                        <select id="supplier_port_id" name="supplier_port_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($supplierPorts as $supplierPort)
                                            <option value="{{ $supplierPort->id }}" {{ isset($supplier) && $supplier->supplier_port_id == $supplierPort->id ? 'selected' : '' }}>{{ $supplierPort->supplier_port_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text supplier_port_id_error"></span>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label" for="markup_multiplier">Markup Multiplier</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="markup_multiplier"
                                            placeholder="Enter Markup Multipler"
                                            name="markup_multiplier"
                                            aria-label="Markup Multipler" value="{{$supplier->markup_multiplier}}" />
                                        <span class="text-danger error-text markup_multiplier_error"></span>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label" for="discount">Discount%</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="discount"
                                            placeholder="Enter Discount"
                                            name="discount"
                                            aria-label="Discount" value="{{$supplier->discount}}" />
                                        <span class="text-danger error-text discount_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" value="1" id="multi_location_supplier" name="multi_location_supplier" {{ isset($supplier) && $supplier->multi_location_supplier == 1 ? 'checked' : '' }} />
                                        <label class="form-label ps-2 mb-0" for="multi_location_supplier">Multi Location Supplier</label>
                                        <span class="text-danger error-text multi_location_supplier_error ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Information -->
                        <!-- account information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Accounting Information</h5>
                            </div>
                            <div class="card-body">
                                <form class="form-repeater">
                                    <div data-repeater-list="group-a">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="credit_limit">Credit Limit</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="credit_limit"
                                                        placeholder="Enter Credit Limit"
                                                        name="credit_limit"
                                                        aria-label="Credit Limit" value="{{$supplier->credit_limit}}" />
                                                    <span class="text-danger error-text credit_limit_error"></span>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="ein_number">EIN Number</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="ein_number"
                                                        placeholder="Enter EIN Number"
                                                        name="ein_number"
                                                        aria-label="EIN Number" value="{{$supplier->ein_number}}" />
                                                    <span class="text-danger error-text ein_number_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="account">Account #</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="account"
                                                        placeholder="Enter Account"
                                                        name="account"
                                                        aria-label="Account" value="{{$supplier->account}}" />
                                                    <span class="text-danger error-text account_error"></span>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="currency_id">Currency <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                    <select id="currency_id" name="currency_id" class="select2 form-select" data-allow-clear="true">
                                                        <option value="">--select--</option>
                                                        @foreach($currencies as $currency)
                                                        <option value="{{ $currency->id }}" {{ isset($supplier) && $supplier->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->currency_name }}-{{ $currency->currency_code }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text currency_id_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="payment_terms_id">Payment Terms <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                    <select id="payment_terms_id" name="payment_terms_id" class="select2 form-select" data-allow-clear="true">
                                                        <option value="">--select--</option>
                                                        @foreach($paymentTerms as $paymentTerm)
                                                        <option value="{{ $paymentTerm->id }}" {{ isset($supplier) && $supplier->payment_terms_id == $paymentTerm->id ? 'selected' : '' }}>{{ $paymentTerm->payment_label }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text payment_terms_id_error"></span>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="shipment_terms_id">Shipment Terms</label>
                                                    <select id="shipment_terms_id" name="shipment_terms_id" class="select2 form-select" data-allow-clear="true">
                                                        @foreach($shipmentTerms as $shipmentTerm)
                                                        <option value="{{ $shipmentTerm->id }}" {{ isset($supplier) && $supplier->shipment_terms_id == $shipmentTerm->id ? 'selected' : '' }}>{{ $shipmentTerm->shipment_term_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text shipment_terms_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="purchase_tax_id">Purchase Tax</label>
                                                    <select id="purchase_tax_id" name="purchase_tax_id" class="select2 form-select" data-allow-clear="true">
                                                        <option value="">--select--</option>
                                                        <option value="1" {{ isset($supplier) && $supplier->purchase_tax_id == 1 ? 'selected' : '' }}>tax 1</option>
                                                        <option value="2" {{ isset($supplier) && $supplier->purchase_tax_id == 2 ? 'selected' : '' }}>tax 2</option>
                                                        <option value="3" {{ isset($supplier) && $supplier->purchase_tax_id == 3 ? 'selected' : '' }}>tax 3</option>
                                                    </select>
                                                    <span class="text-danger error-text purchase_tax_id_error"></span>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="frieght_forwarder_id">Frieght Forwarder</label>
                                                    <select id="frieght_forwarder_id" name="frieght_forwarder_id" class="select2 form-select" data-allow-clear="true">
                                                        <option value="">--select--</option>
                                                        <option value="1" {{ isset($supplier) && $supplier->frieght_forwarder_id == 1 ? 'selected' : '' }}>forwarder 1</option>
                                                        <option value="2" {{ isset($supplier) && $supplier->frieght_forwarder_id == 2 ? 'selected' : '' }}>forwarder 2</option>
                                                        <option value="3" {{ isset($supplier) && $supplier->frieght_forwarder_id == 3 ? 'selected' : '' }}>forwarder 3</option>
                                                    </select>
                                                    <span class="text-danger error-text frieght_forwarder_id_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label class="form-label" for="default_payment_method_id">Default Payment Method</label>
                                                    <select id="default_payment_method_id" name="default_payment_method_id" class="select2 form-select" data-allow-clear="true">
                                                        <option value="">--select--</option>
                                                        @foreach($paymentMethods as $paymentMethod)
                                                        <option value="{{ $paymentMethod->id }}" {{ isset($supplier) && $supplier->default_payment_method_id == $paymentMethod->id ? 'selected' : '' }}>{{ $paymentMethod->payment_method_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text default_payment_method_id_error"></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                                <span class="mb-0 h6"> Form 1099 should be printed for this supplier at the end of every fiscal year</span>
                                                <div class="w-25 d-flex justify-content-end">
                                                    <label class="switch switch-primary switch-sm me-4 pe-2">
                                                        <input type="checkbox" class="switch-input" id="form_1099_printed" name="form_1099_printed" value="1"
                                                            {{ isset($supplier) && $supplier->form_1099_printed == 1 ? 'checked' : '' }} />
                                                        <span class="switch-toggle-slider">
                                                            <span class="switch-on">
                                                                <span class="switch-off"></span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <span class="text-danger error-text form_1099_printed_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- /account information -->
                        <!-- instruction information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Instructions</h5>
                            </div>
                            <div class="card-body">
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-12 col-lg-6">
                                                <label class="form-label mb-1" for="shipping_instruction">Shipping / Delivery Instructions </label>
                                                <textarea id="shipping_instruction" name="shipping_instruction" class="form-control" rows="2" placeholder="Enter Shipping Delivery Instructions" style="resize:none" value="">{{$supplier->shipping_instruction}}</textarea>
                                                <span class="text-danger error-text shipping_instruction_error"></span>
                                            </div>

                                            <div class="mb-3 col-12 col-lg-6">
                                                <label class="form-label mb-1" for="internal_notes">Internal Notes </label>
                                                <textarea id="internal_notes" name="internal_notes" class="form-control" rows="2" placeholder="Enter Internal Notes" style="resize:none" value="">{{$supplier->internal_notes}}</textarea>
                                                <span class="text-danger error-text internal_notes_error"></span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /Instruction information -->
                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-5">
                        <!-- Contact Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Contact Information</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="primary_phone">Primary Phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="primary_phone"
                                            placeholder="Enter Primary Phone"
                                            name="primary_phone"
                                            aria-label="Primary Phone" value="{{$supplier->primary_phone}}" />
                                        <span class="text-danger error-text primary_phone_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="secondary_phone">Secondary Phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="secondary_phone"
                                            placeholder="Enter Secondary Phone"
                                            name="secondary_phone"
                                            aria-label="Secondary Phone" value="{{$supplier->secondary_phone}}" />
                                        <span class="text-danger error-text secondary_phone_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="mobile">Mobile</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="mobile"
                                            placeholder="Enter Mobile"
                                            name="mobile"
                                            aria-label="Mobile" value="{{$supplier->mobile}}" />
                                        <span class="text-danger error-text mobile_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="fax">Fax</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="fax"
                                            placeholder="Enter Fax"
                                            name="fax"
                                            aria-label="Fax" value="{{$supplier->fax}}" />
                                        <span class="text-danger error-text fax_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            placeholder="Enter Email"
                                            name="email"
                                            aria-label="Email" value="{{$supplier->email}}" />
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="website">Website</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="website"
                                            placeholder="Enter Website"
                                            name="website"
                                            aria-label="Website" value="{{$supplier->website}}" />
                                        <span class="text-danger error-text website_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Contact Card -->
                        <!-- Remit to address Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Remit-To Address</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="remit_address">Address</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="remit_address"
                                            placeholder="Enter Address"
                                            name="remit_address"
                                            aria-label="Address" value="{{$supplier->remit_address}}" />
                                        <span class="text-danger error-text remit_address_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="remit_suite">Suite / Unit#</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="remit_suite"
                                            placeholder="Enter Suite / Unit"
                                            name="remit_suite"
                                            aria-label=" Suite / Unit" value="{{$supplier->remit_suite}}" />
                                        <span class="text-danger error-text remit_suite_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="remit_city">City</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="remit_city"
                                            placeholder="Enter City"
                                            name="remit_city"
                                            aria-label="City" value="{{$supplier->remit_city}}" />
                                        <span class="text-danger error-text remit_city_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="remit_state">State</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="remit_state"
                                            placeholder="enter State"
                                            name="remit_state"
                                            aria-label="State" value="{{$supplier->remit_state}}" />
                                        <span class="text-danger error-text remit_state_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="remit_zip">Zip</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="remit_zip"
                                            placeholder="Enter zip"
                                            name="remit_zip"
                                            aria-label="Zip" value="{{$supplier->remit_zip}}" />
                                        <span class="text-danger error-text remit_zip_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="remit_country_id">Country</label>
                                        <select id="remit_country_id" name="remit_country_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text remit_country_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /remit to address Card -->
                        <!-- shipping to address Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="ship_address">Address</label>
                                        <input type="text"
                                            class="form-control"
                                            id="ship_address"
                                            placeholder="Enter Address"
                                            name="ship_address"
                                            aria-label="Address" value="{{$supplier->ship_address}}" />
                                        <span class="text-danger error-text ship_address_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="ship_suite">Suite / Unit#</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ship_suite"
                                            placeholder="Enter Suite / Unit"
                                            name="ship_suite"
                                            aria-label="Suite / Unit" value="{{$supplier->ship_suite}}" />
                                        <span class="text-danger error-text ship_suite_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="ship_city">City</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ship_city"
                                            placeholder="Enter City"
                                            name="ship_city"
                                            aria-label="City" value="{{$supplier->ship_city}}" />
                                        <span class="text-danger error-text ship_city_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="ship_state">State</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ship_state"
                                            placeholder="Enter State"
                                            name="ship_state"
                                            aria-label="State" value="{{$supplier->ship_state}}" />
                                        <span class="text-danger error-text ship_state_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="ship_zip">Zip</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ship_zip"
                                            placeholder="Enter Zip"
                                            name="ship_zip"
                                            aria-label="Zip" value="{{$supplier->ship_zip}}" />
                                        <span class="text-danger error-text ship_zip_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="ship_country_id">Country</label>
                                        <select id="ship_country_id" name="ship_country_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text ship_country_id_error"></span>
                                    </div>
                                     <!-- //status hidden text box -->
                                     <input type="hidden" class="form-control" id="status" name="status" value="1" aria-label="status" />
                                </div>
                            </div>
                        </div>
                        <!-- /shipping to address Card -->
                        <!-- /Organize Card -->

                    </div>
                    <!-- /Second column -->
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Update Supplier</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" name="cancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </form>
</div>

@endsection
@section('scripts')
@include('supplier.__script')
<!-- <script src="{{asset('public/assets/js/app-ecommerce-product-add.js')}}"></script> -->
@endsection