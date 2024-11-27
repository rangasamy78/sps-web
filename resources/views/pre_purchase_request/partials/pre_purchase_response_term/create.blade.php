@extends('layouts.admin')

@section('title', 'Pre Purchase Request Term')
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{ route('pre_purchase_requests.index') }}"
                    class="text-decoration-none text-dark "><span class="text-muted fw-light">Pre Purchase Request
                        /</span><span> Show Pre Purchase Request</span></a></h4>
            <div class="app-ecommerce">
                <form id="prePurchaseResponseForm" name="prePurchaseResponseForm" class="form-horizontal">
                <div class="row">
                    <!-- first column -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-dark fw-bold">My Company</span> : {{ $pre_purchase_supplier_request->supplier->supplier_name }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4 ">
                                        <h5><span class="text-dark fw-bold">Supplier</span>:</h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <input type="text" name="pre_purchase_request_id" id="pre_purchase_request_id" value="{{ $pre_purchase_supplier_request->pre_purchase_request_id }}" class="form-control" />
                                                <input type="hidden" name="supplier_request_id" id="supplier_request_id" value="{{ $pre_purchase_supplier_request->supplier_id }}" class="form-control" />
                                                <label for="supplier_name"><span class="text-dark fw-bold">{{ $pre_purchase_supplier_request->supplier->supplier_name ?? '' }}</span></label>
                                                <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $pre_purchase_supplier_request->supplier->id }}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label
                                                    for="remit_address"><span>{{ $pre_purchase_supplier_request->supplier->remit_address ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label
                                                    for="remit_suite"><span>{{ $pre_purchase_supplier_request->supplier->remit_suite ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="remit_city"><span>{{ $pre_purchase_supplier_request->supplier->remit_city ?? '' }}
                                                        {{ $pre_purchase_supplier_request->supplier->remit_state ?? '' }}
                                                        {{ $pre_purchase_supplier_request->supplier->remit_zip ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label
                                                    for="country_name"><span>{{ $pre_purchase_supplier_request->supplier->remit_country->country_name ?? '' }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 ">
                                        <h5><span class="text-dark fw-bold">Requested By</span></h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="supplier_name"><span
                                                        class="text-dark">{{ $pre_purchase_supplier_request->user->full_name ?? '' }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /first column -->
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Terms : </span> </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Request by</th>
                                                    <th>Payment Terms</th>
                                                    <th>Shippment Terms</th>
                                                    <th>Required Ship Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $pre_purchase_supplier_request->user->full_name ?? '' }} <input type="hidden" name="requested_by_name" id="requested_by_name" value="{{ $pre_purchase_supplier_request->user->full_name }}" class="form-control" /></td>
                                                    <td>{{ $pre_purchase_supplier_request->account_payment_term->payment_label ?? '' }} <input type="hidden" name="requested_payment_terms" id="requested_payment_terms" value="{{ $pre_purchase_supplier_request->account_payment_term->payment_label }}" class="form-control" /></td>
                                                    <td>{{ $pre_purchase_supplier_request->shipment_term->shipment_term_name ?? '' }} <input type="hidden" name="requested_shipment_terms" id="requested_shipment_terms" value="{{ $pre_purchase_supplier_request->shipment_term->shipment_term_name }}" class="form-control" /></td>
                                                    <td>{{ toDbDateDisplay($pre_purchase_supplier_request->required_ship_date ?? '') }} <input type="hidden" name="required_ship_date" id="required_ship_date" value="{{ $pre_purchase_supplier_request->required_ship_date }}" class="form-control" /></td>
                                                </tr>
                                                <tr>
                                                    <td>My Response</td>
                                                    <td>{{ $pre_purchase_supplier_request->account_payment_term->payment_label ?? '' }} <input type="hidden" name="response_payment_terms" id="response_payment_terms" value="{{ $pre_purchase_supplier_request->account_payment_term->payment_label }}" class="form-control" /></td>
                                                    <td>{!! Form::select('response_shipment_term_id', $data['shipmentTerms'], null, [
                                                        'class' => 'form-control select2',
                                                        'id' => 'response_shipment_term_id',
                                                        'placeholder' => '--Select Shipment Term--',
                                                        'data-allow-clear' => 'true',
                                                    ]) !!}
                                                    <input type="hidden" name="response_shipment_terms" id="response_shipment_terms" value="{{ $pre_purchase_supplier_request->shipment_term->shipment_term_name }}" class="form-control" />
                                                    <span class="text-danger error-text response_shipment_term_id_error"></span>
                                                </td>
                                                    <td>{!! Form::date('response_ship_date', null, [
                                                        'class' => 'form-control',
                                                        'id' => 'response_ship_date',
                                                        'placeholder' => 'Enter Response Ship Date',
                                                    ]) !!}
                                                <span class="text-danger error-text response_ship_date_error"></span>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Products</span>:</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="checkAll" /></th>
                                                    <th>Product Name</th>
                                                    <th>req product</th>
                                                    <th>Bundles</th>
                                                    <th>Slabs</th>
                                                    <th>Quantity</th>
                                                    <th>Resp Qty</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reqProducts as $key => $reqProduct)
                                                    <tr>
                                                        <td><input type="checkbox" name="product[{{ $key }}][id]" data-id="{{ $key }}" value="{{ $reqProduct->id }}" class="checkItem"  {{ $reqProduct->total_price ? 'checked' : '' }} /></td>
                                                        <td>{{ $reqProduct->generic_name . ' (' . ($reqProduct->generic_sku ?? '') . ')' }}
                                                            {!! Form::hidden("product[$key][product_sku]", $reqProduct->product_sku, ['class' => 'form-control', 'id' => 'product_sku_' . $key, 'placeholder' => 'Enter product sku', 'disabled']) !!}
                                                            {!! Form::hidden("product[$key][generic_name]", $reqProduct->generic_name, ['class' => 'form-control', 'id' => 'generic_name_' . $key, 'placeholder' => 'Enter generic Name', 'disabled']) !!}
                                                            {!! Form::hidden("product[$key][generic_sku]", $reqProduct->generic_sku, ['class' => 'form-control', 'id' => 'generic_sku_' . $key, 'placeholder' => 'Enter generic Name', 'disabled']) !!}
                                                        </td>
                                                        <td>{!! Form::text("product[$key][requested_product]", null, ['class' => 'form-control', 'id' => 'requested_product_' . $key, 'placeholder' => 'Enter Requested Product', 'disabled']) !!}</td>
                                                        <td>{{ $reqProduct->picking_qty}}</td>
                                                        <td>{{ $reqProduct->slab }}</td>
                                                        <td>{{ $reqProduct->qty." $" }}
                                                            {!! Form::hidden("product[$key][avg_est_cost]", $reqProduct->avg_est_cost, ['class' => 'form-control', 'id' => 'avg_est_cost_' . $key, 'placeholder' => 'Enter avg_est_cost','disabled']) !!}
                                                            {!! Form::hidden("product[$key][pur_qty]", $reqProduct->pur_qty, ['class' => 'form-control', 'id' => 'pur_qty_' . $key, 'placeholder' => 'Enter pur qty','disabled']) !!}
                                                            {!! Form::hidden("product[$key][pur_uom_id]", $reqProduct->pur_uom_id, ['class' => 'form-control', 'id' => 'pur_uom_id_' . $key, 'placeholder' => 'Enter uom id','disabled']) !!}
                                                            {!! Form::hidden("product[$key][length]", $reqProduct->length, ['class' => 'form-control', 'id' => 'length_' . $key, 'placeholder' => 'Enter length','disabled']) !!}
                                                            {!! Form::hidden("product[$key][width]", $reqProduct->width, ['class' => 'form-control', 'id' => 'width_' . $key, 'placeholder' => 'Enter width','disabled']) !!}
                                                            {!! Form::hidden("product[$key][picking_qty]", $reqProduct->picking_qty, ['class' => 'form-control', 'id' => 'picking_qty_' . $key, 'placeholder' => 'Enter picking_qty','disabled']) !!}
                                                            {!! Form::hidden("product[$key][picking_unit]", $reqProduct->picking_unit, ['class' => 'form-control', 'id' => 'picking_unit_' . $key, 'placeholder' => 'Enter picking_unit','disabled']) !!}
                                                            {!! Form::hidden("product[$key][slab]", $reqProduct->slab, ['class' => 'form-control', 'id' => 'slab_' . $key, 'placeholder' => 'Enter slab','disabled']) !!}
                                                            {!! Form::hidden("product[$key][qty]", $reqProduct->qty, ['class' => 'form-control', 'id' => 'qty_' . $key, 'placeholder' => 'Enter qty','disabled']) !!}
                                                        </td>
                                                        <td><div class="input-group mb-3">{!! Form::text("product[$key][response_qty]", $reqProduct->qty , ['class' => 'form-control', 'id' => 'response_qty_' . $key, 'placeholder' => 'Enter Alternative Quantity', 'disabled']) !!} <span class="input-group-text">SF</span></div></td>
                                                        <td><div class="input-group mb-3"><span class="input-group-text">$</span>{!! Form::text("product[$key][unit_price]", $reqProduct->unit_price??null, ['class' => 'form-control unitPrice', 'data-id' => $key, 'id' => 'unit_price_' . $key, 'placeholder' => 'Enter Unit Price', 'disabled']) !!}</div></td>
                                                        <td><div class="input-group mb-3"><span class="input-group-text">$</span>{!! Form::text("product[$key][total_price]", $reqProduct->total_price??null, ['class' => 'form-control', 'id' => 'total_price_' . $key, 'placeholder' => 'Enter Total Price', 'disabled']) !!}</div></td>
                                                        <td>{!! Form::text("product[$key][comments]", $reqProduct->comments??null, ['class' => 'form-control', 'id' => 'comments_' . $key, 'placeholder' => 'Enter Comments', 'disabled']) !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('pre_purchase_response_id', $pre_purchase_supplier_request->pre_purchase_request_id) !!}
                        {!! Form::button('Save Response', ['class' => 'btn btn-primary', 'id' => 'saveResponseData', 'value' => 'create']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
                </form>
            </div> <!-- app-ecommerce -->
        </div>
    </div>
@endsection
@section('scripts')
@include('pre_purchase_request.partials.pre_purchase_response_term.__scripts')
@endsection
