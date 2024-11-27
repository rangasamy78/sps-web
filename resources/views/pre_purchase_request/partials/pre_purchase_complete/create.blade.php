@extends('layouts.admin')

@section('title', 'Pre Purchase Request')
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{ route('pre_purchase_requests.index') }}"
                    class="text-decoration-none text-dark "><span class="text-muted fw-light">Pre Purchase Request /</span><span> Show Pre Purchase Request</span></a></h4>
            <div class="app-ecommerce">
                <form id="prePurchaseCompleteForm" name="prePurchaseCompleteForm" class="form-horizontal">
                <div class="row">
                    <!-- first column -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="text-dark fw-bold">My Company</span> : {{ $pre_purchase_request->supplier->supplier_name }}
                                </h5>
                            </div>
                            <div >
                                <p style="margin-left: 23px;">Your response is as follows</p>
                                <p style="margin-left: 23px;">In this page you can upload images for products.</p>
                                <p style="margin-left: 23px;">Please click on Upload image for each product and upload images</p>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4 ">
                                        <h5><span class="text-dark fw-bold">Requested By</span></h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <input type="hidden" name="pre_purchase_request_id" id="pre_purchase_request_id" value="{{ $pre_purchase_request_id }}" class="form-control" />
                                                <input type="hidden" name="supplier_request_id" id="supplier_request_id" value="{{ $supplier_request_id }}" class="form-control" />
                                                <label for="supplier_name"><span class="text-dark">{{ $pre_purchase_request->user->full_name ?? '' }}</span></label>
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
                                                    <th>Payment Terms</th>
                                                    <th>Shippment Terms</th>
                                                    <th>Shippment Method</th>
                                                    <th>Required Ship Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $pre_purchase_request->account_payment_term->payment_label ?? '' }}</td>
                                                    <td>{{ $pre_purchase_request->shipment_term->shipment_term_name ?? '' }} </td>
                                                    <td>--</td>
                                                    <td>{{ toDbDateDisplay(date('Y-m-d'))}} </td>
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
                                                    <th>Product Name</th>
                                                    <th>Response product</th>
                                                    <th>Resp Qty</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reqProducts as $key => $reqProduct)
                                                    <tr>
                                                        <td>{{ $reqProduct->generic_name . ' (' . ($reqProduct->generic_sku ?? '') . ')' }}</td>
                                                        <td>{{ $reqProduct->generic_name }}</td>
                                                        <td>{{ $reqProduct->qty." $" }}</td>
                                                        <td>{{ $reqProduct->unit_price." $" }}</td>
                                                        <td>{{ $reqProduct->total_price." $" }}</td>
                                                        <td>{{ $reqProduct->comments }}</td>
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
                        {!! Form::hidden('pre_purchase_response_id', $pre_purchase_request->id) !!}
                        {!! Form::button('Save Response', ['class' => 'btn btn-primary', 'id' => 'saveCompletedData', 'value' => 'create']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
                </form>
            </div> <!-- app-ecommerce -->
        </div>
    </div>
@endsection
@section('scripts')
@include('pre_purchase_request.partials.pre_purchase_complete.__scripts')
@endsection
