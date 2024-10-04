
@extends('layouts.admin')
@section('title', 'Show Non Inventory Expenditure')
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Expenditure /</span><span> Show expenditure</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4><span class="card-title mb-0 fw-bold" >{{ $expenditure->expenditure_name ?? '' }}</span><span style="font-size: 14px"> @if(!empty($expenditure->expenditure_code)) ({{ $expenditure->expenditure_code ?? ''  }}) @endif</span></h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="row mb-2">
                                    <div class="col">

                                        <label for="Type"><span class="text-dark fw-bold">Print on Check As / DBA: </span> {{ $expenditure->print_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Location"><span class="text-dark fw-bold">Expenditure Since: </span>{{ $expenditure->since_date ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Parent Location"><span class="text-dark fw-bold">Parent Location: </span>{{ $expenditure->company->company_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Payment Terms"><span class="text-dark fw-bold">Type: </span>{{ $vendor_types->vendor_type_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Payment Terms"><span class="text-dark fw-bold">Payment Terms: </span>{{ $account_payment_terms->payment_label ?? '' }}</label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-6 col-lg-3">
                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Contact Information</h5>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="supplier_name">
                                <span class="text-dark fw-bold">Address:</span>
                                @php
                                    $addressParts = [
                                        $expenditure->address,
                                        $expenditure->city,
                                        $expenditure->state,
                                        $expenditure->zip,
                                        $expenditure->country->country_name ?? '',
                                    ];
                                    $addressString = implode(', ', array_filter($addressParts, fn($part) => !empty($part)));
                                @endphp
                                {{ $addressString ?: '' }}
                            </label>
                        </div>
                    </div>
                    @if(!empty($expenditure->primary_phone))
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">P:</span> {{ $expenditure->primary_phone ?? '' }}</label>
                        </div>
                    </div>
                    @endif
                    @if(!empty($expenditure->secondary_phone))
                    <div class="row mb-2">
                        <div class="col">
                            <label for="secondary_phone"><span class="text-dark fw-bold">P:</span> {{ $expenditure->secondary_phone ?? '' }}</label>
                        </div>
                    </div>
                    @endif
                    @if(!empty($expenditure->fax))
                    <div class="row mb-2">
                        <div class="col">
                            <label for="fax"><span class="text-dark fw-bold">F:</span> {{ $expenditure->fax ?? '' }}</label>
                        </div>
                    </div>
                    @endif
                    @if(!empty($expenditure->mobile))
                    <div class="row mb-2">
                        <div class="col">
                            <label for="mobile"><span class="text-dark fw-bold">M:</span> {{ $expenditure->mobile ?? '' }}</label>
                        </div>
                    </div>
                    @endif
                    @if(!empty($expenditure->email))
                    <div class="row mb-2">
                        <div class="col">
                            <label for="email"><span class="text-dark fw-bold">E:</span> {{ $expenditure->email ?? '' }}</label>
                        </div>
                    </div>
                    @endif
                    @if(!empty($expenditure->website))
                    <div class="row mb-2">
                        <div class="col">
                            <label for="website"><span class="text-dark fw-bold">Url:</span> {{ $expenditure->website ?? '' }}</label>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Accounting Info:</h5>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">Account #:</span> {{ $expenditure->account ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">Taxnumber:</span> {{ $expenditure->ein ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">Memo on Check:</span> {{ $expenditure->memo ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">Currency:</span> {{ $expenditure->currency ?? '' }}</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primary_phone"><span class="text-dark fw-bold">Default Payment Method:</span> {{ $linked_accounts->account_code ?? '' }}  -  {{$linked_accounts->account_name ?? '' }}</label>
                        </div>
                    </div>
                </div>
                @if(!empty($expenditure->is_print_1099))
                <div class="row mb-2">
                    <div class="col">
                        <label for="Payment Terms">Form 1099 to be printed for this vendor</label>
                    </div>
                </div>
                @endif
                @if(!empty($expenditure->is_frieght_expenditure))
                <div class="row mb-2">
                    <div class="col">
                        <label for="Payment Terms" >Bills from this Vendor get prorated towards the Landed Cost of Inventory</label>
                    </div>
                </div>
                @endif
                @if(!empty($expenditure->is_sub_contractor))
                <div class="row mb-2">
                    <div class="col">
                        <label for="Payment Terms">Bills from this Vendor are prorated towards job costing / process costing</label>
                    </div>
                </div>
                @endif

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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#contact">
                                        <i class="bx bx-phone me-2"></i>
                                        <span class="align-middle">Contacts</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#account_payable">
                                        <i class="bx bx-wallet me-2"></i>
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

                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">

                                        @include('expenditure.contact.__contacts')

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
@include('expenditure.__script')
@include('expenditure.contact.__script')
@endsection
