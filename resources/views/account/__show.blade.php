@extends('layouts.admin')

@section('title', 'Show Account')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Account /</span><span> Show Account</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">
                                {{ $account->account_number }}-{{ $account->account_name }}
                                @if($account->status == 0)
                                <span class="text-danger fw-bold">(InActive)</span>
                                @endif
                            </h4>
                            <div class="d-flex align-items-center"> <!-- Container for buttons -->
                                <a href="{{ route('accounts.edit', $account->id) }}"
                                    data-id="{{ $account->id }}"
                                    class="btn btn-primary rounded-circle editbtn"
                                    data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Edit Account"
                                    style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-edit" style="font-size: 18px;"></i>
                                </a>
                                <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class='bx bx-plus-circle icon-color' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Action"></i> <!-- Icon inside the button -->
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item showbtn text-warning' href='{{ route('accounts.index') }}'>
                                            <i class='bx bx-list-ul'></i> List All Account
                                        </a>
                                        <a class='dropdown-item inactivebtn text-success' href='' data-id='{{ $account->id }}'>
                                            <i class='bx bx-check-circle'></i> @if($account->status == 0)Active Account
                                            @else
                                            Inactive Account
                                            @endif
                                        </a>

                                        <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='{{ $account->id }}'>
                                            <i class='bx bx-trash me-1 icon-danger'></i> Delete this Account
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-5">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Account Information</h5>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Account Type:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Parent Location:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Currency:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Operating Location:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Payment Terms:</span> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Bank Information</h5>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Bank Name:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Branch Name:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Phone:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Swift Code:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Routing No:</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Bank Acc No.:</span> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Balance Information</h5>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">Balance as of Today:</span></label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">Balance:</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">$0.00</span></label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">$0.00</span></label>
                                                </div>
                                            </div>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#deposit">
                                        <i class="bx bx-money me-2"></i>
                                        <span class="align-middle">Deposits</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">Payments</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#file">
                                        <i class="bx bx-file me-2"></i>
                                        <span class="align-middle">Files</span>
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
                                        <!-- deposite Tab -->
                                        @include('account.deposit.deposits')
                                        <!-- Payment Tab -->
                                        @include('account.payment.payments')
                                        <!-- Files Tab -->
                                        @include('account.file.files')
                                    </div>
                                </div>
                                <!-- /Options-->
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
@include('account.__script')
@include('account.file.__script')
@endsection