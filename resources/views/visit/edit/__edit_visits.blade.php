@extends('layouts.admin')

@section('title', 'Create Visit')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4 text-dark">Add Visit for Opportunity <span class="text-primary"> # {{$opportunity->opportunity_code}}</span></h4>

        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-header">
                            <h4 class="card-title mb-0 fw-bold">
                                <span class="text-dark fw-bold">{{$opportunity->opportunity_code??''}}- {{$customer->customer_name??''}}</span><br>
                            </h4>
                            @if(optional($opportunity_date))
                            <div class="row p-1">
                                <span>{{$opportunity_date}}</span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                @if(optional($opportunity)->ship_to_type)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Delivery Type</label>
                                            <span class="d-block  text-dark fw-bold">
                                                {{$opportunity->ship_to_type}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(optional($price_list)->price_label)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Price Level</label>
                                            <span id="print_name_value" class="d-block  text-dark fw-bold">
                                                {{$price_list->price_label}}-{{$price_list->price_code??''}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(optional($taxcode)->tax_code)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Sales Tax</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{ $taxcode->tax_code ?? '0%' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(optional($payment_term)->payment_label)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="created_by" class="form-label" style="font-size:8pt">Payment Terms</label>
                                            <span id="print_name_value" class="d-block text-dark fw-bold">
                                                {{ $payment_term->payment_label ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Job Name</label>
                                    @if(optional($opportunity)->ship_to_job_name)
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_job_name}}</span></div>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->ship_to_address)
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary">Bill To</label>
                                    @if(optional($customer)->customer_name)
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold">{{$customer->customer_name}}</span></div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$customer->address??''}}&nbsp;{{$customer->city??''}}&nbsp;{{$customer->state??''}}&nbsp;{{$customer->zip??''}}</span>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-sm-6 border-end p-1 border-dark">
                                    <label class="form-label text-primary">Ship To</label>
                                    @if(optional($opportunity)->ship_to_name)
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold">{{$opportunity->ship_to_name}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt">{{$opportunity->ship_to_address??''}}&nbsp;{{$opportunity->ship_to_city??''}}&nbsp;{{$opportunity->ship_to_state??''}}&nbsp;{{$opportunity->ship_to_zip??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 p-1">
                                    @if(optional($endUseSegment)->end_use_segment)
                                    <div class="row">
                                        <div class="col showContact">
                                            <label class="form-label text-primary">End-Use Segment<div class="text-dark fw-bold">{{$endUseSegment->end_use_segment??''}}</div></label>
                                        </div>
                                    </div>
                                    @endif
                                    @if(optional($projectType)->project_type_name)
                                    <div class="row">
                                        <div class="col showContact">
                                            <label class="form-label text-primary">Project Type<div class="text-dark fw-bold">{{$projectType->project_type_name??''}}</div></label>
                                        </div>
                                    </div>
                                    @endif
                                    @if(optional($howDidHear)->how_did_you_hear_option)
                                    <div class="row">
                                        <div class="col showContact">
                                            <label class="form-label text-primary">How did you hear about us?<div class="text-dark fw-bold">{{$howDidHear->how_did_you_hear_option??''}}</div></label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            @if(optional($company)->company_name)
                                            <div class="row">
                                                <label class="form-label">Location <div class="text-dark fw-bold">{{$company->company_name??''}}</div></label>
                                            </div>
                                            @endif
                                            @if(optional($primarySale)->first_name)
                                            <div class="row">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag text-dark fw-bold fs-5"></i>{{$primarySale->first_name??''}}&nbsp;{{$primarySale->last_name??''}}</span>
                                            </div>
                                            @endif
                                            @if(optional($secondarySale)->first_name)
                                            <div class="row">
                                                <span class="text-dark"><i class="fi fi-rr-user-tag"></i>{{$secondarySale->first_name ??''}}</span>
                                            </div>
                                            @endif
                                        </div>
                                        @if(optional($fabricator)->associate_name)
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="row">
                                                <label class="form-label">Fabricator</label>
                                                <span class="text-dark fw-bold">{{$fabricator->associate_name??''}}</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    @if(optional($opportunity)->internal_notes)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->special_instructions)
                                    <div class="row mt-1">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Special Instructions</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="special_notes_input">{{$opportunity->special_instructions}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /first column -->
            </div>
            <!-- buttons for visit,holds,sample order,quotes -->
            <!-- //visit Details -->
            <form id="formUpdateVisit">
                <div class="row mt-3">
                    <div class="col-lg-6 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-primary fw-bold">Visit Details</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="opportunity_id" id="opportunity_id" value="{{$opportunity->id}}">
                                        <input type="hidden" class="form-control" name="visit_id" id="visit_id" value="{{$visit->id}}">
                                        <label class="form-label">Visit Label</label>
                                        <input type="text" class="form-control" name="visit_label" id="visit_label" placeholder="Enter Visit Label" value="{{$visit->visit_label}}">
                                        <span class="text-danger error-text visit_label_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label class="form-label">Visit Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="date" class="form-control" name="visit_date" id="visit_date" value="{{$visit->visit_date}}">
                                        <span class="text-danger error-text visit_date_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Visit Time</label>
                                        <input type="time" class="form-control" name="visit_time" id="visit_time" value="{{$visit->visit_time}}">
                                        <span class="text-danger error-text visit_time_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Sales Person that helped with Visit</label>
                                        <select class="form-select select2" name="sales_person_id" id="sales_person_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['users'] as $id => $name)
                                            <option value="{{ $id }}" {{ isset($visit) && $visit->sales_person_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sales_person_id_error"></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Price Level</label>
                                        <select class="form-select select2" name="price_level_id" id="price_level_id" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($data['priceListLabels'] as $id => $label)
                                            <option value="{{ $id }}"
                                                {{ isset($opportunity) && $opportunity->price_level_label_id == $id ? 'selected' : '' }}>{{ $label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text price_level_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <label class="form-label">Printed Notes for this Visit</label>
                                        <textarea class="form-control" rows="2" name="visit_printed_notes" id="visit_printed_notes" placeholder="Enter Printed Notes">{{$visit->visit_printed_notes}}</textarea>
                                        <span class="text-danger error-text visit_printed_notes_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-primary fw-bold">Instructions & Notes</span>
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Append new Special Instructions for this Opportunity</label>
                                        <textarea class="form-control" rows="3" name="special_instructions" id="special_instructions" placeholder="Enter Special Instructions">{{$opportunity->internal_notes}}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Append new Internal Notes for this Opportunity </label>
                                        <textarea class="form-control" rows="3 " name="internal_notes" id="internal_notes" placeholder="Enter Internal Notes">{{$opportunity->internal_notes}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary me-2" name="nextStepAddProduct" id="nextStepAddProductBtn">Go To Next Step To Add Products</button>
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
@include('visit.create.__script')
@endsection