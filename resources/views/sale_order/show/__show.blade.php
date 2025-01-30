@extends('layouts.admin')

@section('title', 'Show Sale Order')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('sale_orders.index')}}" class="text-decoration-none text-dark "><span class="text-muted fw-light">Sale Order /</span><span> Show Sale Order</span></a></h4>
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">
                                <span class="text-dark fw-bold">Delivery Sale Order # {{$sale_order->sales_order_code}} {{$sale_order->ship_to_job_name}} @ <a href="{{route('companies.index')}}">{{$company->company_name}}</a></span>
                            </h4>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('sale_orders.edit', $sale_order->id) }}"
                                    data-id="{{ $sale_order->id }}"
                                    class="btn btn-primary rounded-circle editbtn"
                                    data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Update Sale Order"
                                    style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fi fi-rr-pencil fs-4" style="font-size: 18px;"></i>
                                </a>
                                <div class='dropdown ms-2'>
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class='fi fi-rr-redo icon-color fs-4' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="More"></i> <!-- Icon inside the button -->
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('sale_orders.index') }}'>
                                            <i class='bx bx-list-ul'></i> List All Sale Orders
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-duplicate'></i> To be Transferred
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxs-user-detail'></i></i> View Sale Costing Report
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-purchase-tag-alt'></i> Update Bin Numbers
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxs-file-plus'></i> Create Change Order
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxl-paypal'></i> Link / Un-Link Parent Sale Order
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxs-report'></i> Void this Sale Order
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-list-check'></i> View Log
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-list-check'></i> Update Quote Reference
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <!-- <label for="print_name" class="form-label text-dark fw-bold">Print Name / DBA:</label> -->
                                            <span id="print_name_value" class="d-block">
                                                {{ $date }} ({{ \Carbon\Carbon::parse($sale_order->updated_at)->format('h:i A') }})

                                            <label for="created_by" class="form-label text-dark fw-bold font-size" style="font-size:8pt">By</label>
                                            <span id="created_by_value" style="font-size:9pt"> {{$user->first_name ?? ''}} {{$user->last_name ?? ''}} </span></span>
                                        </div>

                                    </div>
                                </div>
                                @if($taxcode && $taxcode->tax_code_label)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <span id="print_name_value" class="d-block">
                                                {{ $taxcode->tax_code_label }}

                                            </span>
                                            <label for="created_by" class="form-label text-dark fw-bold" style="font-size:8pt">Sales Tax</label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        @if($price_list->price_code)
                                        <div class="col-6">
                                            <span id="print_name_value" class="d-block">
                                                {{ $price_list->price_code }}-{{ $price_list->price_label }}
                                            </span>
                                            <label for="created_by" class="form-label text-dark fw-bold" style="font-size:8pt">Price Level</label>
                                        </div>
                                        @endif
                                        @if($payment_term->payment_label)
                                        <div class="col-6">
                                            <span id="print_name_value" class="d-block">
                                                {{ $payment_term->payment_label }}
                                            </span>
                                            <label for="created_by" class="form-label text-dark fw-bold" style="font-size:8pt">Payment Terms</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Bill To:
                                        <input type="hidden" class="form-input customer_id" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$customer->customer_name}}</span>
                                    </h6>
                                    <div class="row">
                                        <div class="col"><label class="form-label">{{$customer->address }}</label></div>
                                        <span>{{$customer->city}} {{$customer->state}} {{$customer->zip}}</span>
                                    </div>
                                    @if ($sale_order->attn)
                                    <div class="row">
                                        <div class="col">
                                            <i class='bx bx-user text-dark'></i>
                                            <label class="form-label ms-1">{{ $sale_order->attn }}</label>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($customer->phone)
                                    <div class="row">
                                        <div class="col">
                                            <i class='bx bx-phone-call text-dark'></i>
                                            <label class="form-label ms-1">{{ $customer->phone }}</label>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($customer->email)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-envelope text-dark'></i><label class="form-label ms-1">{{$customer->email}}</label></div>
                                    </div>
                                    @endif
                                    @if ($sale_order->primary_sales_person_id)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-user text-primary'></i><label class="form-label ms-1">{{$primary_sales->first_name.' '.$primary_sales->last_name}}</label></div>
                                    </div>
                                    @endif
                                    @if ($sale_order->secondary_sales_person_id)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-group text-primary'></i><label class="form-label ms-1">{{$primary_sales->first_name.' '.$primary_sales->last_name}}</label></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Ship To:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$sale_order->ship_to_name}}</span>
                                    </h6>
                                    @if ($sale_order->ship_to_address)
                                    <div class="row">
                                        <div class="col"><label class="form-label">{{$sale_order->ship_to_address}}</label></div>
                                        <span>{{$sale_order->ship_to_city}} {{$sale_order->ship_to_state}} {{$sale_order->ship_to_zip}}</span>
                                    </div>
                                    @endif
                                    @if ($sale_order->ship_to_lot || $sale_order->ship_to_sub_division)
                                    <div class="row">
                                        <div class="col">
                                            @if ($sale_order->ship_to_lot)<span class="text-dark ms-1" style="font-size:0.75rem">Lot: </span>{{$sale_order->ship_to_lot}}@endif
                                            @if ($sale_order->ship_to_sub_division)<span class="text-dark ms-1" style="font-size:0.75rem">Subdivision: </span>{{$sale_order->ship_to_sub_division}}@endif
                                        </div>
                                    </div>
                                    @endif
                                    @if ($sale_order->ship_to_attn)
                                    <div class="row">
                                        <div class="col">
                                            <i class='bx bx-user text-dark'></i>
                                            <label class="form-label ms-1">{{ $sale_order->ship_to_attn }}</label>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($sale_order->ship_to_phone)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-phone-call text-dark'></i><label class="form-label ms-1">{{$sale_order->ship_to_phone}}</label></div>
                                    </div>
                                    @endif
                                    @if ($sale_order->ship_to_fax)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-printer text-dark'></i><label class="form-label ms-1">{{$sale_order->ship_to_fax}}</label></div>
                                    </div>
                                    @endif
                                    @if ($sale_order->ship_to_email)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-envelope text-dark'></i><label class="form-label ms-1">{{$sale_order->ship_to_email}}</label></div>
                                    </div>
                                    @endif
                                    @if (!empty($freight_carrier->expenditure_name))
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Freight Carrier:</span><label class="form-label ms-1">{{$freight_carrier->expenditure_name ?? ''}}</label></div>
                                    </div>
                                    @endif
                                    @if (!empty($route->county_name))
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Route:</span><label class="form-label ms-1">{{$route->county_name ?? ''}}</label></div>
                                    </div>
                                    @endif
                                    @if (!empty($sale_order->shipping_tracking_number))
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Tracking#:</span><label class="form-label ms-1">{{$sale_order->shipping_tracking_number ?? ''}}</label></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Location:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$company->company_name}}</span>
                                    </h6>
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Customer PO#:</span><label class="form-label ms-1">&nbsp;{{$sale_order->customer_po_code ?? 'N/A'}}</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Referred By:</span><label class="form-label ms-1">&nbsp;{{$reffered_by->associate_name ?? 'N/A'}}</label></div>
                                    </div>
                                    @if(!empty($sale_order->commission_amount))
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Commission Amount:</span><span data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-secondary" data-bs-original-title="{{ 'Commission Amount '.$sale_order->commission_amount ?? 'N/A' }}">
                                            <label class="form-label ms-1">&nbsp;<i class='bx bx-user bx-tada bx-flip-horizontal' ></i></label></span></div>
                                    </div>
                                    @endif
                                </div>
                                {{-- {{ $associates->1 }} --}}
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center d-flex justify-content-between p-2 rounded">
                                        Associates:
                                    </h6>
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Fabricator:</span><label class="form-label ms-1">&nbsp;{{$fabricator->associate_name ?? 'N/A'}}</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">Designer:</span><label class="form-label ms-1">&nbsp;{{$designer->associate_name ?? 'N/A'}}</label></div>
                                    </div>
                                    <h6 class="bg-label-primary text-white text-center d-flex justify-content-between p-2 rounded">
                                        Contacts:
                                        <span class="text-dark">
                                            <i class="bx bxs-plus-circle align-middle fs-6" data-bs-toggle="modal" data-bs-target="#listCustomerContact"></i>
                                        </span>
                                    </h6>
                                    <div class="row">
                                        <div class="col showContact">
                                            @foreach ($contacts as $contact)
                                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_{{ $contact['sale_order_contact_id'] }}">
                                                <span class="fw-semibold">{{ $contact['name'] }}</span>
                                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="{{ $contact['sale_order_contact_id'] }}">
                                                    <i class="fas fa-trash-alt fa-xs"></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="alert alert-info bold">This is a Delivery - {{ $sale_order->is_cod == 1 ? 'COD' : '' }}
                                                Sale.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 row_internal_notes">

                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label mb-0 fw-bold text-dark">Add More Internal Notes</label>
                                    <div class="d-flex align-items-center">
                                        <input type="hidden" id="logged_in_user" value="{{ auth()->user()->first_name }}">
                                        <textarea rows="1" class="form-control" name="internal_notes" id="internal_notes"></textarea>
                                        <button type="button" class="btn ms-6" id="updateInternalNote" name="updateInternalNote">
                                            <i class="fas fa-save fa-xl text-dark"></i>
                                        </button>
                                    </div>
                                </div>
                                {{-- @if($sale_order->internal_notes) --}}
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label fw-bold text-dark">Internal Notes</label>
                                    <textarea class="form-control" readonly id="internal_notes_input">{{$sale_order->internal_notes}}</textarea>
                                </div>
                                {{-- @endif --}}
                            </div>
                            <div class="row mt-3">
                                {{-- @if($sale_order->printed_notes) --}}
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label fw-bold text-dark">Printed Notes</label>
                                    <textarea class="form-control" rows="1" readonly id="printed_notes" name="printed_notes">{{$sale_order->printed_notes}}</textarea>
                                </div>
                                {{-- @endif --}}
                            </div>
                            <div class="row mt-3">
                                {{-- @if($sale_order->special_instructions) --}}
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label fw-bold text-dark">Special / Delivery Instructions</label>
                                    <textarea class="form-control" rows="1" readonly id="special_instructions" name="special_instructions">{{$sale_order->special_instructions}}</textarea>
                                </div>
                                {{-- @endif --}}

                                {{-- <div class="col-lg-2 col-sm-5">
                                    <label class="form-label fw-bold text-dark">Probability</label>
                                    <select class="form-control" id="probability_to_close_id" name="probability_to_close_id">
                                        <option value="" disabled selected>--select--</option>
                                        @foreach($data['probabilityCloses'] as $id => $probability_close)
                                        <option value="{{ $id }}" {{ $sale_order->probability_to_close_id == $id ? 'selected' : '' }}>
                                            {{ $probability_close }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div> --}}
                                {{-- <div class="col-lg-2 col-sm-5">
                                    <label class="form-label fw-bold text-dark">Stage</label>
                                    <select class="form-control" id="opportunity_stage_id" name="opportunity_stage_id">
                                        <option value="" disabled selected>--select--</option>
                                        @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                        <option value="{{ $id }}" {{ $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>{{ $opportunity_stage}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                {{-- <div class="col-lg-2 col-sm-2">
                                    <label class="form-label fw-bold text-dark">Total Value</label><br>
                                    <span class="">$23324.00</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3   ">
                    <label for="survey-rating" class="form-label">Survey Rating:</label>
                    <div id="survey-rating">
                        <i class="fi fi-rr-star text-dark"></i>
                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                        <i class="fi fi-rr-clip-mail text-primary fw-dark"></i>
                    </div>
                </div>

                <div class="col-9 text-end p-3">
                    <button
                        type="button"
                        class="btn btn-dark btn-sm"
                        onclick="window.location.href='{{ route('visits.opportunity_detail', $sale_order->id) }}'">
                         Add Pick Ticket
                    </button>
                    <button type="button" class="btn btn-dark  btn-sm"> Add Invoice</button>
                    <button type="button" class="btn btn-dark  btn-sm"> Add P.O.</button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content p-0 pe-md-5">
                                <div class="tab-pane fade show active" id="allOpportunity" role="tabpanel">
                                    <div class="card-datatable table-responsive">
                                        <table class="datatables-basic table tables-basic border-top table-striped" id="datatableSubTransction">
                                            <thead class="table-header-bold">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Days</th>
                                                    <th>Transaction #</th>
                                                    <th>Status / Reason Code</th>
                                                    <th>Created</th>
                                                    <th>Total</th>
                                                    <th>% Fulfill</th>
                                                    <th>actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 order-0 order-md-1">
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#line">
                                        <i class="bx bx-package me-2"></i>
                                        <span class="align-middle">Lines</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#file">
                                        <i class="bx bx-folder me-2"></i>
                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#CRMEvent">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">CRM</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#BillToContact">
                                        <i class="bx bx-phone me-2"></i>
                                        <span class="align-middle">Contacts</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        @include('sale_order.line.lines')
                                        @include('sale_order.file.files')
                                        @include('sale_order.crm_event.crm_events')
                                        @include('sale_order.contact.contacts')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-backdrop fade"></div>
    @include('sale_order.show.__model')
    @include('sale_order.line.__model')
</div>

@endsection
@section('scripts')
@include('sale_order.line.__script')
@include('sale_order.file.__script')
@include('sale_order.show.__script')
@include('sale_order.__script')
@include('sale_order.crm_event.__script')
@include('sale_order.contact.__script')
@endsection
