@extends('layouts.admin')

@section('title', 'Default Link Account')

@section('styles')
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> Default Link Account</h4>
        <div class="row mb-12">
            <div class="col-md">
                @include('default_link_account.__inventory_asset')
            </div>
            <div class="col-md">
                @include('default_link_account.__inventory_In_Transit_on_transfer')
            </div>
        </div>
        <div class="row mb-12 mt-3">
            <div class="col-md">
                @include('default_link_account.__inventory_adjustment')
            </div>
            <div class="col-md">
                @include('default_link_account.__banking_payment')
            </div>
        </div>
        <div class="row mb-12 mt-3">
            <div class="col-md">
                @include('default_link_account.__other_charges_discounts_variance')
            </div>
            <div class="col-md">
                @include('default_link_account.__sale')
            </div>
        </div>
        <div class="row mb-12 mt-3">
            <div class="col-md">
                @include('default_link_account.__accounting')
            </div>
            <div class="col-md">
                @include('default_link_account.__banking_receipt')
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('scripts')
    @include('default_link_account.__scripts')
@endsection
