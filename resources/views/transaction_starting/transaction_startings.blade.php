@extends('layouts.admin')

@section('title', 'Transaction Starting Number')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 pb-4"><span class="text-muted fw-light">Home / </span>Transaction Starting Number</h4>
        <form id="transactionStartingNumberForm" class="form-horizontal">
            <div class="row pb-3">
                <div class="col-lg-7 col-md-10 col-sm-12">
                    <div class="card pb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        </div>
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-12 p-5 pt-0">
                                <input type="hidden" id="transaction_starting_number_id" readonly class="form-control" name="transaction_starting_number_id" value="{{ isset($transactionStartings['id']) ? $transactionStartings['id'] : '' }}">

                                    <div class="row">
                                        <div class="col-6 pb-2">
                                            <label class="form-label fw-bold fs-6" for="type">Type</label>
                                        </div>
                                        <div class="col-6 pb-2">
                                            <label class="form-label fw-bold fs-6" for="type">Starting Number</label>
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6">
                                            <label class="form-label" for="po">PO</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="po_starting_number" class="form-control transaction-starting-number" name="po_starting_number" value="{{isset($transactionStartings['po_starting_number']) ? $transactionStartings['po_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6">
                                            <label class="form-label" for="supplier_invoice">Supplier Invoice</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="supplier_invoice_starting_number" class="form-control transaction-starting-number" name="supplier_invoice_starting_number" value="{{isset($transactionStartings['supplier_invoice_starting_number']) ? $transactionStartings['supplier_invoice_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6">
                                            <label class="form-label" for="presale">PreSale</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="pre_sale_starting_number" class="form-control transaction-starting-number" name="pre_sale_starting_number" value="{{isset($transactionStartings['pre_sale_starting_number']) ? $transactionStartings['pre_sale_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6 mt-2">
                                            <label class="form-label" for="saleorder">Sale Order</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="sale_order_starting_number" class="form-control transaction-starting-number" name="sale_order_starting_number" value="{{isset($transactionStartings['sale_order_starting_number']) ? $transactionStartings['sale_order_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6 mt-2">
                                            <label class="form-label" for="delivery">Delivery</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="delivery_starting_number" class="form-control transaction-starting-number" name="delivery_starting_number" value="{{isset($transactionStartings['delivery_starting_number']) ? $transactionStartings['delivery_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6 mt-2">
                                            <label class="form-label" for="invoice">Invoice</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="invoice_starting_number" class="form-control transaction-starting-number" name="invoice_starting_number" value="{{isset($transactionStartings['invoice_starting_number']) ? $transactionStartings['invoice_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-6 mt-2">
                                            <label class="form-label" for="finance_charge_invoice">Finance Charge Invoice</label>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text" id="finance_charge_invoice_starting_number" class="form-control  transaction-starting-number" name="finance_charge_invoice_starting_number" value="{{isset($transactionStartings['finance_charge_invoice_starting_number']) ? $transactionStartings['finance_charge_invoice_starting_number'] : null;}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </form>
    </div>
</div>

<!-- / Content -->
@endsection
@section('scripts')
@include('transaction_starting.__scripts')
@endsection