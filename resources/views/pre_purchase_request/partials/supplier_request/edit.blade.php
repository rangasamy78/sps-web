@extends('layouts.admin')

@section('title', 'ReSend Pre-Purchase Request')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> ReSend Pre-Purchase Request</span></h4>
            <div class="app-ecommerce">
                {!! Form::model($pre_purchase_supplier_request, [
                    'id' => 'supplierRequestForm',
                    'name' => 'supplierRequestForm',
                    'method' => 'PUT',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                    @include('pre_purchase_request.partials.supplier_request.partials.__supplier_form')
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('supplier_request_id', $pre_purchase_supplier_request->id, ['class' => 'form-control', 'id' => 'supplier_request_id']) !!}
                        {!! Form::button('Update', ['class' => 'btn btn-primary', 'id' => 'saveSupplierData']) !!}
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
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
