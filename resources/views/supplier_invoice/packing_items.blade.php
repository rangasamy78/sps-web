@extends('layouts.admin')

@section('title', 'Supplier Invoice Packing List')
@section('styles')
<style>
    .list-group-item.active {
        background-color: #f9fafb;
        color: white;
        font-weight: bold;
        border-color: #697a8d;
    }

    .list-group-item.active,
    .list-group-item.active:hover,
    .list-group-item.active:focus {
        border-color: #ff69ba;
        background-color: #ff69a9;
        color: #ffffff;
    }

    .list-group-item.active a {
        color: #ffffff;
    }

    td {
        text-align: right;
    }
    .custom-tooltip {
        --bs-tooltip-bg: var(--bs-purple);
        --bs-tooltip-color: var(--bs-white);
    }
    .input-wrapper {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
    .input-wrapper input {
        width: 48%;
    }
    .bold {
        font-weight: bold;
    }
 </style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Supplier Invoice Packing List
        </h4>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Supplier Invoice Packing List</h5>
                    <div class="card-body">
                        @include('supplier_invoice/packing_items/__alert')
                        @include('supplier_invoice/packing_items/__supplier')
                        @include('supplier_invoice/packing_items/__assign_slab_items')
                        @include('supplier_invoice/packing_items/__alt_qty_validation')
                        <table class="table table-striped w-100" id="product_details">
                            <thead>
                                <tr>
                                    <th><b>Product (SKU)</b></th>
                                    <th><b>Alt. Qty</b></th>
                                    <th><b>Billed Qty</b></th>
                                    <th><b>Packinglist Qty</b></th>
                                    <th><b>Received Qty</b></th>
                                    <th><b>Unit Cost</b></th>
                                    <th><b>Total Cost</b></th>
                                    <th><b>Unit Landed Cost</b></th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $j = 1; $subtotal = 0; @endphp
                                @foreach ($poProducts as $key => $poProduct)
                                <!-- Main Row -->
                                @php
                                $itemSubtotal = $poProduct->quantity * $poProduct->unit_price;
                                $subtotal += $itemSubtotal;
                                @endphp
                                <tr>
                                    <td style="text-align: left;">
                                        <a href="{{ route('products.show', $poProduct->product->id ?? '') }}" class="text-secondary">{{ $poProduct->product->product_name ?? '' }}
                                        ({{ $poProduct->product->product_sku ?? '' }}) / {{ $poProduct->description ?? '' }}</a><br />
                                        <button class="btn btn-warning btn add-btn" data-user="main_group_{{ $key }}" data-row="{{ $key }}" type="button" style="width: 20%;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Add slabs"><i class='bx bx-add-to-queue'></i></button>
                                        <button class="btn btn-warning btn edit-btn" data-product-id="{{ $poProduct->product->id }}" data-id="{{ $poProduct->po_id }}"  data-row="{{ $key }}" data-form-id="{{ $j }}" data-user="main_group_{{ $key }}" type="button" style="width: 20%;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Edit slabs"><i class='bx bx-edit-alt me-1 icon-success'></i></button>
                                    </td>
                                    <td style="text-align: left;"> {{ $poProduct->bundles ." Slabs" ?? 0 }}
                                        <input type="hidden" id="alt_qty_{{ $key }}" data-row="{{ $key }}" value="{{ $poProduct->bundles??0 }}" />
                                    </td>
                                    <td style="text-align: left;"> {{ number_format($poProduct->slab_bundles, 2) ." SF" ?? 0.00 }} </td>
                                    <td style="text-align: left;"> {{ number_format($poProduct->slab, 2) ." SF" ?? 0.00 }} </td>
                                    <td style="text-align: left;"> {{ number_format($poProduct->quantity, 2) ." SF" ?? 0.00 }} </td>
                                    <td style="text-align: left;"> {{ $poProduct->unit_price ? "$ ".number_format($poProduct->unit_price, 2) : '0.00' }}</td>
                                    <td style="text-align: left;"> {{ $poProduct->extended ? "$ ".number_format($poProduct->extended, 2) : '0.00' }} </td>
                                    <td style="text-align: left;"> {{ $poProduct->unit_landed_cost ? "$ ".number_format($poProduct->unit_landed_cost, 2) : '0.00' }}</td>
                                    <td style="text-align: left;"></td>
                                    <td>
                                        <a class='dropdown-item proDelBtn text-danger' href='javascript:void(0);' data-row="{{ $key }}" data-id="{{ $poProduct->id }}" title="delete"><i class='bx bx-trash me-1 icon-danger'></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <form method="POST" class="supplier_invoice_product" id="supplier_invoice_product_{{ $key }}" data-id="{{ $key }}">
                                        @csrf
                                        <input type="text" name="supplier_invoice_packing_item_id" value="" hidden>
                                        <input type="text" name="product_id" value="{{ $poProduct->product->id }}" hidden>
                                        <input type="text" name="po_id" value="{{ $poProduct->po_id }}" hidden>
                                        <input type="text" name="sipl_id" value="{{ $sup_invoice_id }}" hidden>
                                        <input type="text" name="row_id" value="{{ $j }}" hidden>
                                        <td colspan="10" id="main_group_{{ $key }}" style="display: none;">
                                            <div class="container mt-3">
                                                <!-- Card Component -->
                                                <div class="card">
                                                    <!-- Card Header -->
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h5 style="text-align: center;">Entry Units/Sizes 1</h5>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h5 style="text-align: center;">Sizes save in</h5>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Card Body -->
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <ul class="list-group list-group-horizontal"
                                                                            id="group_{{ $key }}">
                                                                            <li class="list-group-item active">
                                                                                <a href="#" class="list-item" data-row="{{ $key }}" data-column="1" data-user="unit_detail_{{ $key }}" id="unit_1_{{ $key }}" data-unit="in">IN</a>
                                                                            </li>
                                                                            <li class="list-group-item">
                                                                                <a href="#" class="list-item" data-row="{{ $key }}" data-column="2" data-user="unit_detail_{{ $key }}" id="unit_2_{{ $key }}" data-unit="cm">CM</a>
                                                                            </li>
                                                                            <li class="list-group-item">
                                                                                <a href="#" class="list-item" data-row="{{ $key }}" data-column="3" data-user="unit_detail_{{ $key }}" id="unit_3_{{ $key }}" data-unit="m">M</a>
                                                                            </li>
                                                                            <li class="list-group-item">
                                                                                <a href="#" class="list-item" data-row="{{ $key }}" data-column="4" data-user="unit_detail_{{ $key }}" id="unit_4_{{ $key }}" data-unit="mm">MM</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="row" id="unit_detail_{{ $key }}"
                                                                            style="display: none;">
                                                                            <div class="col-md-6">
                                                                                <input type="number" data-row="{{ $key }}" class="form-control unit_pack_length" name="unit_pack_length" id="unit_pack_length_{{ $key }}" placeholder="Pack Length" min="0" value="">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <input type="number" data-row="{{ $key }}" class="form-control unit_pack_width" name="unit_pack_width" id="unit_pack_width_{{ $key }}" placeholder="Pack Width" min="0" value="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <input type="number" data-row="{{ $key }}" class="form-control pack_length" name="pack_length" id="pack_length_{{ $key }}" placeholder="Pack Length" min="0" value="">
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <input type="number" data-row="{{ $key }}" class="form-control pack_width" name="pack_width" id="pack_width_{{ $key }}" placeholder="Pack Width" min="0" value="">
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <input type="number" data-row="{{ $key }}" class="form-control rec_length" name="rec_length" id="rec_length_{{ $key }}" placeholder="Rec Length" min="0" value="">
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <input type="number" data-row="{{ $key }}" class="form-control rec_width" name="rec_width" id="rec_width_{{ $key }}" placeholder="Rec Width" min="0" value="">
                                                                            </div>
                                                                            <input type="hidden" data-row="{{ $key }}" class="form-control" name="unit_type_name" id="unit_type_name_{{ $key }}" placeholder="Unit Type Name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <!-- scond-row -->
                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <input type="text" class="form-control" value="{{ $poProduct->po_id }}" readonly>
                                                                        <input type="hidden" class="form-control" name="transaction_no" id="transaction_no_{{ $key }}" value="{{ $poProduct->po_id }}" placeholder="Transaction No">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="text" class="form-control testSerialNo" id="serial_no_{{ $key }}" value="{{ $j }}" readonly>
                                                                        <input type="hidden" class="form-control serialNo" name="serial_no" id="serial_no_{{ $key }}" value="{{ $j }}" placeholder="Serial No">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control maxLotBlock" id="block_{{ $key }}" name="lot_block" placeholder="Lot / Block" value="">
                                                                            <span class="input-group-text" id="basic-addon2"><input  type="checkbox" id="isBlockCheck_{{ $key }}" name="isBlockCheck" value="1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Auto Increment of Bundle number"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control maxBundle" id="bundle_{{ $key }}" name="bundle" placeholder="Bundle" value="">
                                                                            <span class="input-group-text" id="basic-addon2"><input  type="checkbox" id="isBundleCheck_{{ $key }}" name="isBundleCheck" value="1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Auto Increment of Lot/Block number"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control maxSupplierRef" id="supplier_ref_{{ $key }}" name="supplier_ref" placeholder="Supp Ref" value="">
                                                                            <span class="input-group-text" id="basic-addon2"><input  type="checkbox" id="isSuppRefCheck_{{ $key }}" name="isSuppRefCheck" value="1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Auto Increment of Supp. Ref number"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <select class="form-select bin_type" data-id="{{ $key }}" id="bin_type_id_{{ $key }}" name="bin_type_id" data-allow-clear="true">
                                                                            <option value="">--Select Bin Type--</option>
                                                                            @foreach ($binTypes as $bin => $binType)
                                                                            <option value="{{ $bin }}">{{ $binType }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <input type="hidden" class="form-control" id="bin_type_name_{{ $key }}" name="bin_type_name" placeholder="Bin Type Name">
                                                                    <input type="hidden" class="form-control" id="present_location_{{ $key }}" name="present_location" placeholder="Present Location" value="ULTRA STONES LLC - NY">
                                                                </div>
                                                            </div>
                                                        </div> <!-- scond-row -->
                                                        <div class="row mt-5">
                                                            <div class="col-md-1">
                                                                <button class="btn btn-primary cancel" id="cancel_{{ $key }}" data-target="main_group_{{ $key }}">Cancel</button>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" name="notes" id="notes_{{ $key }}" placeholder="notes" value="notes">
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-center">
                                                                <button class="btn btn-primary decrementBtn" data-row="{{ $key }}" name="decrementBtn" id="decrementBtn_{{ $key }}" data-target="count_{{ $key }}">-</button>
                                                                <input type="number" class="form-control mx-2" name="count" id="count_{{ $key }}" placeholder="count" value="1">
                                                                <button class="btn btn-primary incrementBtn" data-row="{{ $key }}" name="incrementBtn" id="incrementBtn_{{ $key }}" data-target="count_{{ $key }}">+</button>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center">
                                                                <button class="btn btn-primary slabBtn" name="slabBtn" data-row="{{ $key }}" id="slabBtn_{{ $key }}">Add Slab(s)</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                                <!-- New Nested Table -->
                                <tr row="{{ $j }}">
                                    <td colspan="10" id="update_form_{{ $key }}">
                                        <form method="POST" class="supplier_invoice_update_product" id="supplier_invoice_update_product_{{ $key }}" data-id="{{ $key }}">
                                            @csrf
                                            <table class="table table-bordered w-100" id="product_item_{{ $j }}">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">S.no</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;"><img src="{{ asset('public/images/bacode_icon.png') }}" alt="Associate Icon" style="width: 24px; height: auto;"></th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">Lot/Block</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">Bundle</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">Supp. Ref</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">Present Location</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">Packinglist Sizes</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">Received Sizes</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">N</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">D</th>
                                                        <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;">S</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                </tfoot>
                                            </table>
                                        </form>
                                    </td>
                                </tr>
                                @php $j++; @endphp

                            @endforeach

                            </tbody>
                            </tfoot>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                                <td colspan="2">Sub Total: $
                                    <?= number_format($subtotal, 2); ?>
                                </td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                                <td colspan="2">Total: $
                                    <?= number_format($subtotal, 2); ?>
                                </td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                                <td colspan="2">Balance Due: $
                                    <?= number_format($subtotal, 2); ?>
                                </td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                                <td colspan="2" class="padBig right "><a href="#" class="btn btn-primary">Make
                                        Payment</a></td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('supplier_invoice.packing_items.__scripts')
@endsection
