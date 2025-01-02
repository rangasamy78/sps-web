@extends('layouts.admin')

@section('title', 'Edit Sample Order Opportunity')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <form id="opportunitySampleOrderEditForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{route('create.sample_orders.index')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Sample Order /</span>
                    Update Opportunity + Sample Order</span>
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
                                        <label class="form-label" for="opportunity_date">Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="hidden" class="form-control" readonly id="opportunity_id" name="opportunity_id" value="{{$opportunity->id}}">
                                        <input type="text" class="form-control" readonly id="opportunity_code" name="opportunity_code" value="{{$opportunity->opportunity_code}}">
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <input type="hidden" class="form-control" id="opportunity_id" name="opportunity_id" value="{{$opportunity->id}}">
                                        <input type="hidden" class="form-control" id="login_user_id" name="login_user_id" value="{{ Auth::id() }}">
                                        <label class="form-label" for="opportunity_date">Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" id="opportunity_date" name="opportunity_date" aria-label="date" value="{{$opportunity->opportunity_date}}" />
                                        <span class="text-danger error-text opportunity_date_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="location_id">Location <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="location_id" name="location_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}" {{ isset($opportunity) && $opportunity->location_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger error-text location_id_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="end_use_segment_id">End-use Segment</label>
                                        <select id="end_use_segment_id" name="end_use_segment_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach ($data['endUseSegments'] as $id => $end_use_segment)
                                            <option value="{{ $id }}"
                                                {{ isset($opportunity) && $opportunity->end_use_segment_id == $id ? 'selected' : '' }}>
                                                {{ $end_use_segment }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text end_use_segment_id_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="code">Project Type</label>
                                        <select id="project_type_id" name="project_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach ($data['projectTypes'] as $id => $project_type_name)
                                            <option value="{{ $id }}"
                                                {{ isset($opportunity) && $opportunity->project_type_id == $id ? 'selected' : '' }}>
                                                {{ $project_type_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text project_type_id_error"></span>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-md-3 pt-sm-2">
                                        <label class="form-label" for="code">Stage</label>
                                        <select id="opportunity_stage_id" name="opportunity_stage_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                            <option value="{{ $id }}"
                                                {{ isset($opportunity) && $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>
                                                {{ $opportunity_stage}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text stage_id_error"></span>
                                    </div>


                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12 col-sm-8 col-md-12 pt-sm-2">
                                        <label class="form-label" for="code">Contact Mode</label>

                                        <div class="d-flex align-items-center flex-wrap gap-1 p-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio1" value="1" {{ isset($opportunity) && $opportunity->contact_mode == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="radio1"><i class="fi fi-ss-walking fs-3"></i></label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio2" value="2" value="1" {{ isset($opportunity) && $opportunity->contact_mode == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="radio2"><i class="fi fi-ss-phone-call fs-3"></i></label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio3" value="3" value="1" {{ isset($opportunity) && $opportunity->contact_mode == 3 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="radio3"><i class="fi fi-rs-fax fs-3"></i></label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact_mode" id="radio4" value="4" value="1" {{ isset($opportunity) && $opportunity->contact_mode == 4 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="radio4"><i class="fi fi-ss-envelope fs-3"></i></label>
                                            </div>
                                        </div>

                                        <span class="text-danger error-text contact_mode_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- First column-->
                    <div class="col-12 col-lg-5">
                        <!-- Account Information -->
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
                                        <input type="text" class="form-control" id="attn" name="attn" aria-label="attn" value="{{$opportunity->attn}}" />
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
                                        <label class="form-label" for="price_level_label_id">Price Level <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="price_level_label_id" name="price_level_label_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}"
                                                {{ isset($opportunity) && $opportunity->price_level_label_id == $id ? 'selected' : '' }}>{{ $label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_label_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="primary_sales_person_id">Primary Sales Person <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="primary_sales_person_id" name="primary_sales_person_id" class="form-select select2" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($opportunity) && $opportunity->primary_sales_person_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text primary_sales_person_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="secondary_sales_person_id">Secondary Sales Person</label>
                                        <select id="secondary_sales_person_id" name="secondary_sales_person_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $user)
                                            <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->secondary_sales_person_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text secondary_sales_person_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="total_value">Total Value $</label>
                                        <input type="text" class="form-control" id="total_value" name="total_value" aria-label="Total Value" />
                                        <span class="text-danger error-text total_value_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="sales_tax_id">Sales Tax</label>
                                        <select id="sales_tax_id" name="sales_tax_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['salesTaxs'] as $id => $tax_name)
                                            <option value="{{ $id }}" {{ isset($billCustomer) && $billCustomer->sales_tax_id == $id ? 'selected' : '' }}>{{ $tax_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sales_tax_id_error"></span>
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

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row mb-1">
                                            <div class="mb-2 col">
                                                <label class="form-label mb-1" for="special_instructions">Special / Delivery Instructions</label>
                                                <textarea id="special_instructions" name="special_instructions" rows="3" class="form-control" placeholder="Enter Special / Delivery Instruction" style="resize:none">{{$opportunity->special_instructions}}</textarea>
                                                <span class="text-danger error-text special_instructions_error"></span>
                                            </div>
                                            <div class="mb-2 col-12">
                                                <label class="form-label mb-1" for="branch_name">Internal Notes</label>
                                                <textarea id="internal_notes" name="internal_notes" class="form-control" rows="3" placeholder="Enter Internal Notes" style="resize:none">{{$opportunity->internal_notes}}</textarea>
                                                <span class="text-danger error-text internal_notes_error"></span>
                                            </div>
                                            <div class="mb-2 col-12">
                                                <label class="form-label mb-1" for="printed_notes">Printed Notes</label>
                                                <textarea id="printed_notes" name="printed_notes" class="form-control" rows="3" placeholder="Enter Printed Notes" style="resize:none">{{$opportunity->printed_notes}}</textarea>
                                                <span class="text-danger error-text printed_notes_error"></span>
                                            </div>
                                            <!-- Sample Order Notes -->
                                            <div class="row mt-2 mb-2">
                                                <h5 class="card-title mb-0 text-dark fw-bold">Sample Delivery Notes</h5>
                                            </div>
                                            <div class="row">
                                                <div class="mb-2 col">
                                                    <label class="form-label" for="fabricator_id">Sample Order Label</label>
                                                    <input type="text" class="form-control" id="sample_order_label" name="sample_order_label" placeholder="Enter Sample Order Label" value="{{$sampleOrder->sample_order_label}}" aria-label="Total Value" />
                                                    <span class="text-danger error-text sample_order_label_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-2 col">
                                                    <label class="form-label" for="sample_order_special_instructions">Special Instructions for this Sample Order</label>
                                                    <textarea id="sample_order_special_instructions" name="sample_order_special_instructions" class="form-control" rows="3" placeholder="Enter Special Instructions" style="resize:none">{{$sampleOrder->sample_order_special_instructions}}</textarea>
                                                    <span class="text-danger error-text designer_id_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-2 col">
                                                    <label class="form-label" for="sample_order_printed_notes">Printed Notes for this Sample Order</label>
                                                    <textarea id="sample_order_printed_notes" name="sample_order_printed_notes" class="form-control" rows="3" placeholder="Enter Printed Notes" style="resize:none">{{$sampleOrder->sample_order_printed_notes}}</textarea>
                                                    <span class="text-danger error-text sample_order_printed_notes_error"></span>
                                                </div>
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
                    <div class="col-12 col-lg-7">
                        <!-- Contact Information Card -->
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
                                    <!-- Common Fields -->
                                    <div id="common-fields">
                                        <div class="row mb-2">
                                            <div class="col-8">
                                                <label class="form-label" for="ship_to_job_name">
                                                    End Customer / Job Name
                                                    <button type="button" id="copy_bill_to" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Bill To)</button>
                                                    <button type="button" id="copy_lot_division" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Lot / Division)</button>
                                                </label>
                                                <input type="text" class="form-control" id="ship_to_job_name" name="ship_to_job_name" placeholder="Enter End Customer / Job Name" value="{{$opportunity->ship_to_job_name}}" />
                                                <span class="text-danger error-text ship_to_job_name_error"></span>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="ship_to_attn">Attn</label>
                                                <input type="text" class="form-control" id="ship_to_attn" name="ship_to_attn" placeholder="Enter Attn" value="{{$opportunity->ship_to_attn}}" />
                                                <span class="text-danger error-text ship_to_attn_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delivery-Specific Fields -->
                                    <div id="delivery-fields" class="conditional-fields">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label" for="ship_to">Ship To<button type="button" id="ship_to_copy_bill" name="ship_to_copy_bill" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Bill To)</button></label>
                                                <input type="hidden" class="form-control" id="ship_to_id" readonly name="ship_to_id" aria-label="Ship To" value="{{$opportunity->ship_to_id}}" />
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
                                                <input type="text" class="form-control" id="ship_to_name" placeholder="Enter Ship To Name" name="ship_to_name" aria-label="ShipTo Name" value="{{$opportunity->ship_to_name}}" />
                                                <span class="text-danger error-text ship_to_name_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_address">Address</label>
                                                <input type="text" class="form-control" id="ship_to_address" placeholder="Enter Address" name="ship_to_address" aria-label="Address" value="{{$opportunity->ship_to_address}}" />
                                                <span class="text-danger error-text ship_to_address_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_suite">Suite / Unit#</label>
                                                <input type="text" class="form-control" id="ship_to_suite" placeholder="Enter Suite / Unit" name="ship_to_suite" aria-label="Suite / Unit" value="{{$opportunity->ship_to_suite}}" />
                                                <span class="text-danger error-text ship_to_suite_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_city">City</label>
                                                <input type="text" class="form-control" id="ship_to_city" placeholder="Enter City" name="ship_to_city" aria-label="City" value="{{$opportunity->ship_to_city}}" />
                                                <span class="text-danger error-text ship_to_city_error"></span>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_state">State</label>
                                                <input type="text" class="form-control" id="ship_to_state" placeholder="Enter State" name="ship_to_state" aria-label="State" value="{{$opportunity->ship_to_state}}" />
                                                <span class="text-danger error-text ship_to_state_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_zip">Zip <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <input type="text" class="form-control" id="ship_to_zip" placeholder="Enter Zip" name="ship_to_zip" aria-label="Zip" value="{{$opportunity->ship_to_zip}}" />
                                                <span class="text-danger error-text ship_to_zip_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">

                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_county_id">County</label>
                                                <select id="ship_to_county_id" name="ship_to_county_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['counties'] as $id => $county_name)
                                                    <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->ship_to_county_id == $id ? 'selected' : '' }}>{{ $county_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text ship_to_county_id_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_country_id">Country</label>
                                                <select id="ship_to_country_id" name="ship_to_country_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['countries'] as $id => $country_name)
                                                    <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->ship_to_country_id == $id ? 'selected' : '' }}>{{ $country_name}}</option>
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
                                                <input type="text" class="form-control" id="ship_to_phone" name="ship_to_phone" placeholder="Enter Phone" value="{{$opportunity->ship_to_phone}}" />
                                                <span class="text-danger error-text ship_to_phone_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_fax">Fax</label>
                                                <input type="text" class="form-control" id="ship_to_fax" placeholder="Enter Fax" name="ship_to_fax" aria-label="ship_to_Fax" value="{{$opportunity->ship_to_fax}}" />
                                                <span class="text-danger error-text ship_to_fax_error"></span>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_mobile">Mobile</label>
                                                <input type="text" class="form-control" id="ship_to_mobile" placeholder="Enter Mobile" name="ship_to_mobile" aria-label="Mobile" value="{{$opportunity->ship_to_mobile}}" />
                                                <span class="text-danger error-text ship_to_mobile_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_lot">Lot</label>
                                                <input type="text" class="form-control" id="ship_to_lot" placeholder="Enter Lot" name="ship_to_lot" aria-label="Lot" value="{{$opportunity->ship_to_lot}}" />
                                                <span class="text-danger error-text ship_to_lot_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_sub_division">Subdivision</label>
                                                <input type="text" class="form-control" id="ship_to_sub_division" placeholder="Enter Subdivision" name="ship_to_sub_division" aria-label="Subdivision" value="{{$opportunity->ship_to_sub_division}}" />
                                                <span class="text-danger error-text ship_to_sub_division_error"></span>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="ship_to_email">Email</label>
                                                <input type="text" class="form-control" id="ship_to_email" placeholder="Enter Email" name="ship_to_email" aria-label="Email" value="{{$opportunity->ship_to_email}}" />
                                                <span class="text-danger error-text ship_to_email_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label" for="how_did_hear_about_us_id">How did you hear about us? <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <select id="how_did_hear_about_us_id" name="how_did_hear_about_us_id" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--select--</option>
                                                    @foreach($data['aboutUsOptions'] as $id => $how_did_you_hear_option)
                                                    <option value="{{ $id }}" {{ isset($opportunity) && $opportunity->how_did_hear_about_us_id == $id ? 'selected' : '' }}>{{ $how_did_you_hear_option}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text how_did_hear_about_us_id_error"></span>
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <input class="form-check-input" type="checkbox" value="1" id="is_do_not_send_email" name="is_do_not_send_email" {{ isset($opportunity) && $opportunity->is_do_not_send_email == 1 ? 'checked' : '' }} />
                                                <label class="form-label ps-2 mb-0" for="is_do_not_send_email"> Do not send any email updates.
                                                </label>
                                                <span class="text-danger error-text is_do_not_send_email_error ms-2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pick-Up Specific Fields -->
                                    <div id="pickup-fields" class="conditional-fields d-none">
                                        <!-- feature update -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /Contact Card -->
                        <!-- Remit to address Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Associates:</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row">
                                    <div class="mb-1 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="fabricator_id">Fabricator</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly name="fabricator_name" id="fabricator_name" value="{{$fabricator->associate_name??''}}" />
                                                <input type="hidden" id="fabricator_id" name="fabricator_id" value="{{$opportunity->fabricator_id}}" />
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
                                    <div class="mb-1 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="designer_id">Designer</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="designer_name" name="designer_name" value="{{$designer->associate_name??''}}" />
                                                <input type="hidden" id="designer_id" name="designer_id" value="{{$opportunity->designer_id}}" />
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
                                    <div class="mb1 col-lg-11">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label" for="builder_id">Builder</label>
                                            <button type="button" class="btn btn-border-0 text-dark ms-auto me-4 fw-bold" data-bs-toggle="modal" data-bs-target="#AddNewAssociate">Add New</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control bg-label-secondary" readonly id="builder_name" name="builder_name" value="{{$builder->associate_name??''}}" />
                                                <input type="hidden" id="builder_id" name="builder_id" value="{{$opportunity->builder_id}}" />
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
                                    <input type="hidden" class="form-control" id="status" name="status" value="1" aria-label="status" />
                                </div>
                            </div>
                        </div>
                        <!-- /remit to address Card -->
                        <!-- smaple order notes -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-dark fw-bold">Sample Delivery Method</h5>
                            </div>
                            <div class="card-body">
                                <input type="hidden" class="form-control" id="sample_order_id" placeholder="Enter Attn" name="sample_order_id" value="{{$sampleOrder->id}}" aria-label="Attn" />
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="delivery_type" class="form-label">Delivery Type</label>
                                            <button type="button" id="sample_order_copy_bill_to" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Bill To)</button>
                                            <button type="button" id="sample_order_copy_job_address" class="btn btn-link p-0 ms-3" style="text-decoration: underline;">(Copy Job Address)</button><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="pickup" name="delivery_type" value="pickup" {{ $sampleOrder->delivery_type == 'pickup' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark fw-bold" for="pickup">Pickup</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="delivery" name="delivery_type" value="delivery" {{ $sampleOrder->delivery_type == 'delivery' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark fw-bold" for="delivery">Delivery</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- delivery type -->
                                @php
                                $display = $sampleOrder->delivery_type == 'delivery' ? 'display:block' : 'display:none';
                                @endphp

                                <div id="sample-order-delivery-fields" style="{{$display}}">
                                    <div class="row mt-2">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label" for="delivery_attn">Attn</label>
                                            <input type="text" class="form-control" id="delivery_attn" placeholder="Enter Attn" name="delivery_attn" value="{{$sampleOrder->delivery_attn}}" aria-label="Attn" />
                                            <span class="text-danger error-text delivery_attn_error"></span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label" for="delivery_tracking">Tracking #</label>
                                            <input type="text" class="form-control" id="delivery_tracking" placeholder="Enter Tracking" name="delivery_tracking" value="{{$sampleOrder->delivery_tracking}}" aria-label="Tracking" />
                                            <span class="text-danger error-text delivery_tracking_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_address">Address</label>
                                            <input type="text" class="form-control" id="delivery_address" placeholder="Enter Address" name="delivery_address" value="{{$sampleOrder->delivery_address}}" aria-label="Address" />
                                            <span class="text-danger error-text delivery_address_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_suite">Suite / Unit#</label>
                                            <input type="text" class="form-control" id="delivery_suite" placeholder="Enter Suite / Unit" name="delivery_suite" value="{{$sampleOrder->delivery_suite}}" aria-label="Suite" />
                                            <span class="text-danger error-text delivery_suite_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_city">City </label>
                                            <input type="text" class="form-control" id="delivery_city" placeholder="Enter City" name="delivery_city" value="{{$sampleOrder->delivery_city}}" aria-label="City" />
                                            <span class="text-danger error-text delivery_city_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_state">State</label>
                                            <input type="text" class="form-control" id="delivery_state" placeholder="Enter State" name="delivery_state" value="{{$sampleOrder->delivery_state}}" aria-label="State" />
                                            <span class="text-danger error-text delivery_state_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_zip">Zip</label>
                                            <input type="text" class="form-control" id="delivery_zip" placeholder="Enter Zip" name="delivery_zip" value="{{$sampleOrder->delivery_zip}}" aria-label="Zip" />
                                            <span class="text-danger error-text delivery_zip_error"></span>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="delivery_county_id">County</label>
                                            <select id="delivery_county_id" name="delivery_county_id" class="select2 form-select" data-allow-clear="true">
                                                <option value="">--select--</option>
                                                @foreach($data['counties'] as $id => $county_name)
                                                <option value="{{ $id }}" {{ isset($sampleOrder) && $sampleOrder->delivery_county_id == $id ? 'selected' : '' }}>{{ $county_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text delivery_country_id_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <input type="hidden" class="form-control" id="status" name="status" value="1" aria-label="status" />
                                </div>
                            </div>
                        </div>
                        <!-- end sample order notes -->
                        <!-- /Organize Card -->
                    </div>
                    <!-- /Second column -->
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="updateOpportunitySampleOrder" name="updateOpportunitySampleOrder">Update Opportunity + Sample Order</button>
                        <button type="button" class="btn btn-secondary btn-md" id="editCancelButton" name="editCancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade">
        </div>
    </form>
    @include('opportunity.edit.__model')
</div>
@endsection
@section('scripts')
@include('opportunity.edit.__script')
@include('sample_order.edit.__script_opportunity_sample_orders')
@endsection