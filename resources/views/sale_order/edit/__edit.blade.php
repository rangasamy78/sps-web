@extends('layouts.admin')

@section('title', 'Edit Sale Order')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/editor.css')}}" />
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection
@section('content')
<div class="content-wrapper">
    <form id="saleOrderEditForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{route('sale_orders.index')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Sale Order /</span>
                    Edit Sale Order</span>
                </a></h4>
            <div class="app-ecommerce">

                <div class="row">
                    <div class="col-12">
                        <div class="card  mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="sales_order_code">SO # <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="sales_order_code" name="sales_order_code" value="{{$sale_order->sales_order_code}}">
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <input type="hidden" class="form-control" id="sales_order_id" name="sales_order_id" value="{{$sale_order->id}}">
                                        <input type="hidden" class="form-control" id="entered_by_id" name="entered_by_id" value="{{ Auth::id() }}">
                                        <label class="form-label" for="sales_order_date">Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="sales_order_date" name="sales_order_date" aria-label="date" value="{{$sale_order->sales_order_date}}" />
                                        <span class="text-danger error-text sale_order_date_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="customer_po_code">Customer P.O#</label>
                                        <input type="text" class="form-control" id="customer_po_code"
                                            name="customer_po_code" aria-label="customer_po_code" value="{{$sale_order->customer_po_code}}" />
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="location_id">Location <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="location_id" name="location_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}" {{ isset($sale_order) && $sale_order->location_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger error-text location_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-5">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Bill To</h5>
                                <button type="button" class="btn btn-border-0 text-dark ms-auto fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewCustomer">Add New</button>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="billing_customer_id">Billing Customer <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="hidden" class="form-control bg-label-secondary" readonly id="billing_customer_id" name="billing_customer_id" value="{{$billCustomer->id}}" />
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-label-secondary" readonly id="billing_customer_name" name="billing_customer_name" aria-label="Biiling Customer" value="{{$billCustomer->customer_name}}" />
                                            <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                data-bs-target="#searchCustomer">
                                                <i class="fi fi-rr-search text-white"></i>
                                            </span>
                                        </div>
                                        <span class="text-danger error-text billing_customer_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="attn">Attn</label>
                                        <input type="text" class="form-control" id="attn" name="attn" aria-label="attn" value="{{$sale_order->attn}}" />
                                        <span class="text-danger error-text attn_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="address">Address </label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="address" name="address" aria-label="attn" value="{{$billCustomer->address}}" />
                                        <span class="text-danger error-text address_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="suite">Suite / Unit#</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="suite" name="suite" aria-label="suite / Unit#" value="{{$billCustomer->address_2}}" />
                                        <span class="text-danger error-text suite_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="city">City</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="city" name="city" aria-label="city" value="{{$billCustomer->city}}" />
                                        <span class="text-danger error-text city_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="state">State</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="state" name="state" aria-label="state" value="{{$billCustomer->state}}" />
                                        <span class="text-danger error-text state_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="zip">Zip</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="zip" name="zip" aria-label="zip" value="{{$billCustomer->zip}}" />
                                        <span class="text-danger error-text zip_error"></span>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="country">Country</label>
                                        <select id="country" name="country" class="select2 form-select" disabled data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['countries'] as $id => $country_name)
                                            <option value="{{ $id }}">{{ $country_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text country_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="phone" name="phone" aria-label="phone" value="{{$billCustomer->phone}}" />
                                        <span class="text-danger error-text phone_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="fax">Fax</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="fax" name="fax" aria-label="fax" value="{{$billCustomer->fax}}" />
                                        <span class="text-danger error-text fax_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="mobile">Mobile</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="mobile" name="mobile" aria-label="mobile" value="{{$billCustomer->mobile}}" />
                                        <span class="text-danger error-text mobile_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" class="form-control bg-label-secondary" readonly id="email" name="email" aria-label="email" value="{{$billCustomer->email}}" />
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="payment_term_id">Payment Terms <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="payment_term_id" name="payment_term_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['paymentTerms'] as $payment_term)
                                            <option value="{{ $payment_term->id }}"
                                                {{ isset($sale_order) && $sale_order->payment_term_id == $payment_term->id ? 'selected' : '' }}>{{ $payment_term->payment_label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text payment_term_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="price_level_label_id">Price Level <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="price_level_label_id" name="price_level_label_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}"
                                                {{ isset($sale_order) && $sale_order->price_level_label_id == $id ? 'selected' : '' }}>{{ $label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_label_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="primary_sales_person_id">Primary Sales Person <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="primary_sales_person_id" name="primary_sales_person_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($sale_order) && $sale_order->primary_sales_person_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text primary_sales_person_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="secondary_sales_person_id">Secondary Sales Person</label>
                                        <select id="secondary_sales_person_id" name="secondary_sales_person_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $user)
                                            <option value="{{ $id }}" {{ isset($sale_order) && $sale_order->secondary_sales_person_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text secondary_sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_cod" name="is_cod" {{ isset($sale_order) && $sale_order->is_cod == 1 ? 'checked' : '' }} />
                                        <label class="form-label ps-2 mb-0" for="is_cod"> Is C.O.D
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Account Information -->
                        <!-- instruction information -->
                        <div class="card mb-4 bankCard">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Notes/Instructions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 conditional-fields" id="delivery-freight-fields">
                                    <div class="col-12">
                                        <label class="form-label ps-2 mb-0" for="freight_carrier_id"> Freight Carrier</label>
                                        <select id="freight_carrier_id" name="freight_carrier_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['expenditures'] as $expenditure)
                                            <option value="{{ $expenditure->id }}" {{ isset($sale_order) && $sale_order->freight_carrier_id == $expenditure->id ? 'selected' : '' }}>{{ $expenditure->expenditure_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label ps-2 mb-0" for="route_id"> county</label>
                                        <select id="route_id" name="route_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['counties'] as $id => $label)
                                            <option value="{{ $id }}" {{ isset($sale_order) && $sale_order->route_id == $id ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label ps-2 mb-0" for="route_id"> Tracking#</label>
                                        <input type="text" class="form-control" id="shipping_tracking_number" name="shipping_tracking_number" aria-label="shipping_tracking_number" value={{ $sale_order->shipping_tracking_number}} />
                                    </div>
                                </div>
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row mb-1">
                                            <div class="mb-3 col">
                                                <label class="form-label mb-1" for="special_instructions">Special / Delivery Instructions</label>
                                                <textarea id="special_instructions" name="special_instructions" class="form-control" rows="3" placeholder="Enter Special / Delivery Instruction" style="resize:none">{{$sale_order->special_instructions}}</textarea>
                                                <span class="text-danger error-text special_instructions_error"></span>
                                            </div>

                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="branch_name">Internal Notes</label>
                                                <textarea id="internal_notes" name="internal_notes" class="form-control" rows="3" placeholder="Enter Internal Notes" style="resize:none">{{$sale_order->internal_notes}}</textarea>
                                                <span class="text-danger error-text internal_notes_error"></span>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="printed_notes">Printed Notes</label>
                                                <textarea id="printed_notes" name="printed_notes" class="form-control" rows="3" placeholder="Enter Printed Notes" style="resize:none">{{$sale_order->printed_notes}}</textarea>
                                                <span class="text-danger error-text printed_notes_error"></span>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label mb-1" for="printed_notes">Sale Order Terms</label>
                                                <select id="print_doc_disclaimer_id" name="print_doc_disclaimer_id" class="form-select select2" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['printDocDisclaimer'] as $id => $label)
                                                    <option value="{{ $id }}" {{ isset($sale_order) && $sale_order->print_doc_disclaimer_id == $id ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <div class="col-12">
                                                    <div id="print_doc_description_editor_content">&nbsp;</div>
                                                </div>
                                                <textarea class="form-control" id="print_doc_description_editor" name="print_doc_description_editor" rows="2" style="resize:none;display:none">{{ old('print_doc_description_editor', $sale_order->print_doc_description_editor) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Ship To</h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3 d-flex" id="pills-tab" role="tablist">
                                    <li class="nav-item me-4" role="presentation">
                                        <button class="nav-link active" id="ship_to_type" name="ship_to_type" value="Delivery" data-type="delivery" data-bs-toggle="pill" data-bs-target="#pills-delivery" type="button" role="tab">
                                            Delivery
                                        </button>
                                    </li>
                                    <li class="nav-item me-4" role="presentation">
                                        <button class="nav-link" id="ship_to_type" name="ship_to_type" value="Pick Up" data-type="pickup" data-bs-toggle="pill" data-bs-target="#pills-pickup" type="button" role="tab">
                                            Pick Up
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="common-fields">
                                        <div class="row mb-2">
                                            <div class="col-8">
                                                <label class="form-label" for="ship_to_job_name">
                                                    End Customer / Job Name
                                                    <button type="button" id="copy_bill_to" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Bill To)</button>
                                                    <button type="button" id="copy_lot_division" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Lot / Division)</button>
                                                </label>
                                                <input type="text" class="form-control" id="ship_to_job_name" name="ship_to_job_name" placeholder="Enter End Customer / Job Name" value="{{$sale_order->ship_to_job_name}}" />
                                                <span class="text-danger error-text ship_to_job_name_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="ship_to_attn">Attn</label>
                                                <input type="text" class="form-control" id="ship_to_attn" name="ship_to_attn" placeholder="Enter Attn" value="{{$sale_order->ship_to_attn}}" />
                                                <span class="text-danger error-text ship_to_attn_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="delivery-fields" class="conditional-fields">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label" for="ship_to">Ship To<button type="button" id="ship_to_copy_bill" name="ship_to_copy_bill" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Bill To)</button></label>
                                                <input type="hidden" class="form-control" id="ship_to_id" readonly name="ship_to_id" aria-label="Ship To" value="{{$sale_order->ship_to_id}}" />
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="ship_to" readonly name="ship_to" aria-label="Ship To" value="{{$billCustomer->customer_name}}" />
                                                    <span class="input-group-text bg-primary" id="ship_to_icon">
                                                        <i class="fi fi-rr-search text-white"></i>
                                                    </span>
                                                </div>
                                                <span class="text-danger error-textship_to_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_name">ShipTo Name</label>
                                                <input type="text" class="form-control" id="ship_to_name" placeholder="Enter Ship To Name" name="ship_to_name" aria-label="ShipTo Name" value="{{$sale_order->ship_to_name}}" />
                                                <span class="text-danger error-text ship_to_name_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_address">Address</label>
                                                <input type="text" class="form-control" id="ship_to_address" placeholder="Enter Address" name="ship_to_address" aria-label="Address" value="{{$sale_order->ship_to_address}}" />
                                                <span class="text-danger error-text ship_to_address_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_suite">Suite / Unit#</label>
                                                <input type="text" class="form-control" id="ship_to_suite" placeholder="Enter Suite / Unit" name="ship_to_suite" aria-label="Suite / Unit" value="{{$sale_order->ship_to_suite}}" />
                                                <span class="text-danger error-text ship_to_suite_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_city">City</label>
                                                <input type="text" class="form-control" id="ship_to_city" placeholder="Enter City" name="ship_to_city" aria-label="City" value="{{$sale_order->ship_to_city}}" />
                                                <span class="text-danger error-text ship_to_city_error"></span>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_state">State</label>
                                                <input type="text" class="form-control" id="ship_to_state" placeholder="Enter State" name="ship_to_state" aria-label="State" value="{{$sale_order->ship_to_state}}" />
                                                <span class="text-danger error-text ship_to_state_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_zip">Zip <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <input type="text" class="form-control" id="ship_to_zip" placeholder="Enter Zip" name="ship_to_zip" aria-label="Zip" value="{{$sale_order->ship_to_zip}}" />
                                                <span class="text-danger error-text ship_to_zip_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">

                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_county_id">County</label>
                                                <select id="ship_to_county_id" name="ship_to_county_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['counties'] as $id => $county_name)
                                                    <option value="{{ $id }}" {{ isset($sale_order) && $sale_order->ship_to_county_id == $id ? 'selected' : '' }}>{{ $county_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text ship_to_county_id_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_country_id">Country</label>
                                                <select id="ship_to_country_id" name="ship_to_country_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['countries'] as $id => $country_name)
                                                    <option value="{{ $id }}" {{ isset($sale_order) && $sale_order->ship_to_country_id == $id ? 'selected' : '' }}>{{ $country_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text ship_to_country_id_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="common-fields">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_phone">Phone</label>
                                                <input type="text" class="form-control" id="ship_to_phone" name="ship_to_phone" placeholder="Enter Phone" value="{{$sale_order->ship_to_phone}}" />
                                                <span class="text-danger error-text ship_to_phone_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_fax">Fax</label>
                                                <input type="text" class="form-control" id="ship_to_fax" placeholder="Enter Fax" name="ship_to_fax" aria-label="ship_to_Fax" value="{{$sale_order->ship_to_fax}}" />
                                                <span class="text-danger error-text ship_to_fax_error"></span>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_mobile">Mobile</label>
                                                <input type="text" class="form-control" id="ship_to_mobile" placeholder="Enter Mobile" name="ship_to_mobile" aria-label="Mobile" value="{{$sale_order->ship_to_mobile}}" />
                                                <span class="text-danger error-text ship_to_mobile_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_email">Email</label>
                                                <input type="text" class="form-control" id="ship_to_email" placeholder="Enter Email" name="ship_to_email" aria-label="Email" value="{{$sale_order->ship_to_email}}" />
                                                <span class="text-danger error-text ship_to_email_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="sales_tax_id">Sales Tax</label>
                                                <select id="sales_tax_id" name="sales_tax_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['salesTaxs'] as $id => $tax_name)
                                                    <option value="{{ $id }}" {{ isset($sale_order) && $sale_order->sales_tax_id == $id ? 'selected' : '' }}>{{ $tax_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text sales_tax_id_error"></span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-3">
                                                <label class="form-label ps-2 mb-0" for="requested_ship_date"> Req. Ship/Pick Up Date</label>
                                                <input class="form-control" type="date" id="requested_ship_date" name="requested_ship_date" value="{{ $sale_order->requested_ship_date }}"/>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-3">
                                                <label class="form-label ps-2 mb-0" for="est_delivery_date"> ETA Date</label>
                                                <input class="form-control" type="date" id="est_delivery_date" name="est_delivery_date" value="{{ $sale_order->est_delivery_date }}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_sub_division">Subdivision</label>
                                                <input type="text" class="form-control" id="ship_to_sub_division" placeholder="Enter Subdivision" name="ship_to_sub_division" aria-label="Subdivision" value="{{$sale_order->ship_to_sub_division}}" />
                                                <span class="text-danger error-text ship_to_sub_division_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_lot">Lot</label>
                                                <input type="text" class="form-control" id="ship_to_lot" placeholder="Enter Lot" name="ship_to_lot" aria-label="Lot" value="{{$sale_order->ship_to_lot}}" />
                                                <span class="text-danger error-text ship_to_lot_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pickup-fields" class="conditional-fields d-none">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Associates:</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="fabricator_id">Fabricator</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="fabricator_name" id="fabricator_name" value="{{$fabricator->associate_name}}" />
                                                <input type="hidden" id="fabricator_id" name="fabricator_id" value="{{$sale_order->fabricator_id}}" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                    data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearFabricator" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="fabricator"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text fabricator_id_error"></span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="designer_id">Designer</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="designer_name" name="designer_name" value="{{$designer->associate_name}}" />
                                                <input type="hidden" id="designer_id" name="designer_id" value="{{$sale_order->designer_id}}" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                    data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearDesigner" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="designer"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text designer_id_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="builder_id">Builder</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="builder_name" name="builder_name" value="{{$builder->associate_name}}" />
                                                <input type="hidden" id="builder_id" name="builder_id" value="{{$sale_order->builder_id}}" />
                                                <span class="input-group-text bg-primary" data-bs-toggle="modal"
                                                    data-bs-target="#searchAssociate">
                                                    <i class="fi fi-rr-search text-white"></i>
                                                </span>
                                            </div>
                                            <button type="button" id="clearBuilder" class="btn btn-label-danger button ms-2 btn-sm clear-associate" data-target="builder"><i class="fi fi-rr-cross fw-bold"></i></button>
                                        </div>
                                        <span class="text-danger error-text internal_notes_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-3 mb-3">
                                        <label class="form-label ps-2 mb-0" for="commission_amount"> Commission Amount</label>
                                        <input class="form-control" type="text" id="commission_amount" name="commission_amount" value="{{$sale_order->commission_amount}}" />
                                    </div>
                                    <div class="col-12 col-sm-8 mb-3">
                                        <label class="form-label ps-2 mb-0" for="commission_notes"> Commission Notes</label>
                                        <input class="form-control" type="text" id="commission_notes" name="commission_notes" value="{{$sale_order->commission_notes}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" class="form-control" id="status" name="status" value="1" aria-label="status" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Save New Sale Order</button>
                        <button type="button" class="btn btn-secondary btn-md" id="editCancelButton" name="editCancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade">
        </div>
    </form>
    @include('sale_order.edit.__model')
</div>
@endsection
@section('scripts')
@include('sale_order.edit.__script')
@include('sale_order.__script')
<script src="{{asset('public/assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('public/assets/vendor/libs/quill/quill.js')}}"></script>
@endsection
