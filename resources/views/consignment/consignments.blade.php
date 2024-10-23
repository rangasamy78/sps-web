@extends('layouts.admin')

@section('title', 'Consignment')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home /</span> Consignment</a></h4>
        <!-- Product List Widget -->
        <div class="row">
            <div class="col-12 order-0 order-md-1">
                <!-- Navigation -->
                <div class="col-12  mx-auto card-separator">
                    <div class="d-flex justify-content-between mb-3">
                        <ul class="nav nav-pills flex-column flex-md-row mb-4">
                            <li class="nav-item me-3">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allAccount">
                                    <i class="bx bx-wallet me-sm-1"></i>
                                    <span class="align-middle">Consignment Locations</span>
                                </button>
                            </li>
                            <li class="nav-item me-3">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#newAddcount" onclick="window.location.href='{{ route('consignments.create') }}';">
                                    <i class="bx bx-plus me-sm-1"></i>
                                    <span class="align-middle">New Consignment Locations</span>
                                </button>
                            </li>
                            <li class="nav-item me-3">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allTrialBalance">
                                    <i class="bx bx-receipt me-2"></i>
                                    <span class="align-middle">Supplier Consignment Locations</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Navigation -->
                <div class="card mb-4">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Options -->
                            <div class="col-12">
                                <div class="tab-content p-0 pe-md-5  ">
                                    @include('consignment.all_consignment_list.all_consignment_lists')
                                </div>
                            </div>
                            <!-- /Options-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('consignment.__script')
@endsection