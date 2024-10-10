
@extends('layouts.admin')
@section('title', 'Show Associate')
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Associate /</span><span> Show Associate</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">{{ $associate->associate_name ?? '' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Type"><span class="text-dark fw-bold">Type: </span> {{ $associate->associate_type->customer_type_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Location"><span class="text-dark fw-bold">Location: </span>{{ $associate->location->company_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Primary Sales Person"><span class="text-dark fw-bold">Primary Sales Person: </span>{{ $associate->user->name ?? '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3">
                    <h5 style="">Contact Information</h5>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="supplier_name">
                                <span class="text-dark fw-bold">Address:</span>
                                @php
                                    $addressParts = [
                                        $associate->address,
                                        $associate->contact_name,
                                        $associate->city,
                                        $associate->state,
                                        $associate->zip,
                                    ];
                                    $addressString = implode(', ', array_filter($addressParts, fn($part) => !empty($part)));
                                @endphp
                                {{ $addressString ?: '' }}
                            </label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">P:</span> {{ $associate->primary_phone ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="secondary_phone"><span class="text-dark fw-bold">F:</span> {{ $associate->secondary_phone ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="mobile"><span class="text-dark fw-bold">E:</span> {{ $associate->mobile ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="website"><span class="text-dark fw-bold">Url:</span> {{ $associate->website ?? '' }}</label>
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
                <div class="col-12 order-0 order-md-1">
                    <!-- Navigation -->
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item me-3">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#contacts">
                                        <i class="bx bx-phone me-2"></i>
                                        <span class="align-middle">Contacts</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files_data">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <!-- /Navigation -->
                    <div class="card mb-4">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        <div class="tab-pane fade show active" id="contacts">
                                        @include('associate.contact.__contacts')
                                        </div>
                                        <div class="tab-pane fade" id="files_data">
                                        @include('associate.file.files')
                                        </div>


                                    </div>
                                </div>
                            </div>
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
@include('associate.__scripts')
@include('associate.contact.__script')
@include('associate.file.__script')
@endsection
