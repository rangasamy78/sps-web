@extends('layouts.admin')

@section('title', 'Consignment')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Consignment /</span> Create Consignment</a></h4>
        <!-- Product List Widget -->
        <div class="row">
            <div class="col-12 order-0 order-md-1">
                <!-- Navigation -->
                <div class="col-12  mx-auto card-separator">
                    <div class="d-flex justify-content-between mb-3">
                        <ul class="nav nav-pills flex-column flex-md-row mb-4">
                            <li class="nav-item me-3">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allAccount" onclick="window.location.href='{{ route('consignments.index') }}';">
                                    <i class="bx bx-wallet me-sm-1"></i>
                                    <span class="align-middle">Consignment Locations</span>
                                </button>
                            </li>
                            <li class="nav-item me-3">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#newAddcount" onclick="window.location.href='{{ route('consignments.create') }}';">
                                    <i class="bx bx-plus me-sm-1"></i>
                                    <span class="align-middle">New Consignment Locations</span>
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
                            <div class="col-lg-7 col-12">
                                <div class="tab-content p-0 pe-md-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex gap-lg-4">
                                                <div class="form-check">
                                                    <input class="form-check-input radio" type="radio" checked name="radioGroup" id="radio1" value="1">
                                                    <label class="form-check-label" for="radio1">Active Consignment Locations </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input radio" type="radio" name="radioGroup" id="radio2" value="0">
                                                    <label class="form-check-label" for="radio2">Inactive Consignment Locations</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input radio" type="radio" name="radioGroup" id="radio3" value="2">
                                                    <label class="form-check-label" for="radio3">Both</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 g-3"> <!-- Added spacing between columns -->
                                        <div class="col-lg-6 col-12"> <!-- Changed to md for better responsiveness -->
                                            <div class="card h-100 existing_customer" style="cursor: pointer;"> <!-- Ensures equal height for both cards -->
                                                <div class="card-header d-flex justify-content-center align-items-center"> <!-- Used card-header for consistency -->
                                                    <img src="{{asset('public/images/transportation.png')}}" alt="image not found" width="100px" height="80px">
                                                </div>
                                                <div class="card-body d-flex justify-content-center align-items-center text-center"> <!-- Added text-center for better text alignment -->
                                                    <h6 class="card-text">Setup an Existing Customer as a Consignment Location</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12"> <!-- Changed to md for better responsiveness -->
                                            <div class="card h-100" style="cursor: pointer;" onclick="window.location.href='{{ route('customers.create') }}';"> <!-- Ensures equal height for both cards -->
                                                <div class="card-header d-flex justify-content-center align-items-center"> <!-- Used card-header for consistency -->
                                                    <img src="{{ asset('public/images/cargo-ship.png') }}" alt="image not found" width="100px" height="80px">
                                                </div>
                                                <div class="card-body d-flex justify-content-center align-items-center text-center"> <!-- Added text-center for better text alignment -->
                                                    <h6 class="card-text">Add a new Customer and setup as a Consignment Location</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-12">
                                <h5>Filter</h5>
                                <div class="row customerModelFilter">
                                    <div class="col-lg-6">
                                        <label class="mb-2 fw-bold text-dark">Customer Name: </label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Search by Customer Name">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 fw-bold text-dark">Contact Name: </label>
                                        <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Search by Contact Name">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <label class="mb-2 fw-bold text-dark">Address: </label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Search by Address" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 fw-bold text-dark">Phone: </label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Search by phone" />
                                    </div>
                                </div>
                            </div>
                            <!-- /Options-->
                        </div>
                    </div>
                </div>
                <!-- consignment datatable -->
                <div class="card mb-4">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Options -->
                            <div class="col-12">
                                <div class="tab-content p-0 pe-md-5">
                                    <div class="tab-pane fade show active" id="allAccount" role="tabpanel">
                                        <!-- <h4 class="card-title">Consignment</h4> -->
                                        <div class="d-flex justify-content-between align-items-center row py-3 gap-2 gap-md-0">

                                        </div>
                                        <div class="card-datatable table-responsive">
                                            <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesCreateConsignment">
                                                <thead class="table-header-bold">
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Contact Name</th>
                                                        <th>Address</th>
                                                        <th>Phone</th>
                                                        <th>Qty Currently Holding</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Options-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search box of list customer -->
    <div class="modal fade" id="CreateConsignmentModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row customerModelFilter">
                        <div class="col-lg-4">
                            <label class="mb-2 fw-bold text-dark">Customer Name: </label>
                            <input type="text" class="form-control" id="popup_customer_name" name="popup_customer_name" placeholder="Search by Customer Name">
                        </div>
                        <div class="col-lg-4">
                            <label class="mb-2 fw-bold text-dark">Fabricator or Code: </label>
                            <input type="text" class="form-control" id="popup_code" name="popup_code" placeholder="Search by Fabricator or Code">
                        </div>
                        <div class="col-lg-4">
                            <label class="mb-2 fw-bold text-dark">Phone/Contact Name: </label>
                            <input type="text" class="form-control" name="popup_contact_input" id="popup_contact_input" placeholder="Search by phone or contact name" />
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesListCustomer">
                            <thead class="table-header-bold">
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
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