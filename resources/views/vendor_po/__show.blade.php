@extends('layouts.admin')
@section('title', 'Show Vendor PO')
@section('styles')
<style>
.product-link {
    color: black;
    text-decoration: none;
}

.associate-link:hover {
    text-decoration: underline;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Vendor PO /</span><span> Show Vendor PO</span></h4>
        <div class="app-ecommerce">
            <div class="row">

                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">Vendor PO Detail</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Vendor PO"><span class="text-dark fw-bold">Vendor PO: #</span>
                                                {{ $vendor_po->transaction_number ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <?php
                                        $formattedDate = $vendor_po->transaction_date ? \Carbon\Carbon::parse($vendor_po->transaction_date)->format('d-m-Y') : ''; ?>
                                            <label for=""><span class="text-dark fw-bold">
                                                    &nbsp;</span>{{ $formattedDate ?? '' }}</label>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Vendor Details"><span class="text-dark fw-bold">Vendor Details:
                                                </span> </label>
                                            <br>{{$vendor_po->vendor->expenditure_name ?? ''}}<br>
                                            {{$vendor_po->address ?? ''}}<br>
                                            {{$vendor_po->address2 ?? ''}}<br>
                                            {{$vendor_po->city ?? ''}}<br>
                                            {{$vendor_po->state ?? ''}}<br>
                                            {{$vendor_po->zip ?? ''}}<br>
                                            {{$vendor_po->country->country_name ?? ''}}<br>

                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="">
                                                <span class="text-dark fw-bold">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                                {{ $vendor_po->phone ?? '' }} &nbsp;&nbsp; &nbsp;&nbsp;
                                                <span class="text-dark fw-bold">
                                                    <i class="fas fa-fax"></i>
                                                </span>
                                                {{ $vendor_po->fax ?? '' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="">
                                                <span class="text-dark fw-bold">
                                                    Payment Terms:
                                                </span>
                                                {{ $vendor_po->payment_terms->payment_label ?? '' }} &nbsp;&nbsp;
                                                &nbsp;&nbsp;
                                                <span class="text-dark fw-bold">
                                                    Location:
                                                </span>
                                                {{ $vendor_po->location->company_name ?? '' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Internal Notes"><span class="">Internal Notes: </span>
                                                {{ $vendor_po->internal_notes ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Printed Notes"><span class="">Printed Notes: </span>
                                                {{ $vendor_po->printed_notes ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="card pt-0 p-4">
                            <div class="row">
                                <div class="col">
                                    <table class="datatables-basic table tables-basic border-top table-striped"
                                        id="datatable_bill">
                                        <input type="hidden" name="vendor_po_id" id="vendor_po_id"
                                            value="{{ $vendor_po->id}}">
                                        <thead class="table-header-bold">
                                            <tr class="odd gradeX">
                                                <th>Invoice #</th>
                                                <th>Trans. Date</th>
                                                <th>Inv. Date</th>
                                                <th>Due Date</th>
                                                <th>Vendor</th>
                                                <th>Amount</th>
                                                <th>Balance Due </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 order-0 order-md-1">

                    <div class="col-12 mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item me-3">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#po_details">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">PO Details</span>
                                    </button>
                                </li>

                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">CRM</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        <div class="tab-pane fade show active" id="po_details">
                                            @include('vendor_po.po_detail.po_details')
                                        </div>
                                        <div class="tab-pane fade" id="files">
                                            @include('vendor_po.file.files')
                                        </div>
                                        <div class="tab-pane fade" id="crm">
                                            @include('vendor_po.crm.crms')
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
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('vendor_po.__scripts')
@include('vendor_po.pre_payment.__scripts')
@include('vendor_po.bills.__scripts')
@include('vendor_po.file.__script')
@endsection