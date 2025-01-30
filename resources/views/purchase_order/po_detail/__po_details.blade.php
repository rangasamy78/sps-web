@extends('layouts.admin')
@section('title', 'PO Details')
@section('styles')
<style>
.text-right {
    text-align: right;

}

tfoot td {
    font-weight: bold;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> PO /</span><span> PO Detail</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type"><span class="text-dark fw-bold">PO #:
                                                    {{ $purchase_order->po_number ?? '' }} </span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Location"><span class="text-dark fw-bold"> <?php
$formattedDate = $purchase_order->po_date ? \Carbon\Carbon::parse($purchase_order->po_date)->format('d-m-Y') : ''; ?>
                                                    <label><span
                                                            class="text-dark fw-bold">&nbsp;</span>{{ $formattedDate ?? '' }}</label></span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Parent Location"><span
                                                    class="text-dark fw-bold">Supplier:</span><span>
                                                    {{ $purchase_order->supplier->supplier_name ?? '' }}</span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Payment Terms"><span class="text-dark fw-bold">Ship To:
                                                </span><span>
                                                    {{ $purchase_order->location->company_name ?? '' }}</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name">
                                                <span class="text-dark fw-bold">Purchase Location:
                                                    : </span><span>
                                                    {{ $purchase_order->location->company_name ?? '' }}</span>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Payment
                                                    Terms:</span><span>
                                                    {{ $purchase_order->payment_terms->payment_label ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="{{$purchase_order->id}}">
                <div class="col-12 order-0 order-md-1">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="product_details_table">
                                    <thead>
                                        <tr>
                                            <th>SO</th>
                                            <th>Product (SKU)</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Extended</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchasePo as $po)
                                        <tr>
                                            <td>{{ $po->so }}</td>
                                            <td>{{ $po->product->product_name }}</td>
                                            <td>{{ $po->description }}</td>
                                            <td class="quantity">{{ $po->quantity }}</td>
                                            <td class="unit_price">{{ $po->unit_price }}</td>
                                            <td class="extended">{{ $po->quantity * $po->unit_price }}</td>
                                            <td class="action">
                                                <button class="btn btn-warning btn-sm edit-btn-po"
                                                    data-product_name="{{ $po->product->product_name }}"
                                                    data-id="{{ $po->id }}">Edit</button>
                                                <button class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $po->id }}">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="alight:right;">
                                            <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                            <td id="subtotal">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                            <td id="total">0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 order-0 order-md-1">
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item me-3">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#product_details">
                                        <span class="align-middle">Products</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#charges">

                                        <span class="align-middle">Other Charges</span>
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
                                        <div class="tab-pane fade show active" id="product_details">
                                            @include('purchase_order.product.product_details')
                                        </div>
                                        <div class="tab-pane fade" id="charges">
                                            @include('purchase_order.other_charge.other_charges')
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

@include('purchase_order.po_detail.__scripts')
@endsection