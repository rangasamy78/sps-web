@extends('layouts.admin')

@section('title', 'Add Customer')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Add Customer</span></h4>
            <div class="app-ecommerce">
                {!! Form::open([
                    'id' => 'customerForm',
                    'name' => 'customerForm',
                    'method' => 'POST',
                    // 'route' => 'customers.store',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                @include('customer.partials._customer_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('id', '') !!}
                        {!! Form::button('Save Customer', ['class' => 'btn btn-primary', 'id' => 'savedata', 'value' => 'create']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        @endsection
        @section('scripts')
            @include('customer.__scripts')
        @endsection
