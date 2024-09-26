@extends('layouts.admin')

@section('title', 'Edit Customer')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Edit Customer</span></h4>
            <div class="app-ecommerce">
                {!! Form::model($customer, [
                    'id' => 'customerForm',
                    'name' => 'customerForm',
                    'method' => 'PUT',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                @include('customer.partials._customer_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('id', $customer->id, ['class' => 'form-control', 'id' => 'id']) !!}
                        {!! Form::button('Update', ['class' => 'btn btn-primary', 'id' => 'savedata']) !!}
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        @endsection
        @section('scripts')
            @include('customer.__scripts')
        @endsection
