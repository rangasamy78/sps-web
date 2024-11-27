@extends('layouts.admin')

@section('title', 'Add Pre Purchase Request')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Add Pre Purchase Request</span></h4>
            <div class="app-ecommerce">
                {!! Form::open([
                    'id' => 'prePurchaseRequestForm',
                    'name' => 'prePurchaseRequestForm',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                ]) !!}
                @include('pre_purchase_request.partials.__pre_purchase_request_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('pre_purchase_request_id', '') !!}
                        {!! Form::button('Save Pre Purchase Request', ['class' => 'btn btn-primary', 'id' => 'savedata', 'value' => 'create']) !!}
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
    @include('pre_purchase_request.__scripts')
@endsection
