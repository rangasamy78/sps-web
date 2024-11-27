@extends('layouts.admin')

@section('title', 'Send Pre-Purchase Request')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Send Pre-Purchase Request</span></h4>
            <div class="app-ecommerce">
                {!! Form::open([
                    'id' => 'supplierRequestForm',
                    'name' => 'supplierRequestForm',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                    @include('pre_purchase_request.partials.supplier_request.partials.__supplier_form')
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('supplier_request_id', '') !!}
                        {!! Form::button('Save Supplier Requests', ['class' => 'btn btn-primary', 'id' => 'saveSupplierData', 'value' => 'create']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('pre_purchase_request.partials.supplier_request.__scripts');
@endsection
