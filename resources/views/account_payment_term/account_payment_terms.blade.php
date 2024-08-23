@extends('layouts.admin')

@section('title', 'Account Payment Term')

@section('styles')
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card-datatable">
            <div class="container-toast">
                <div class="card-header py-2">
                    <ul class="nav nav-pills flex-wrap" role="tablist">
                        <span style="margin-right: 20px;">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-browser" aria-controls="navs-pills-browser"
                                    aria-selected="true" style="border: 1px solid #696cff;"
                                    name="btn_payment_standard_date_driven" id="payment_standard_date_driven_1"
                                    value="1">
                                    Standard Payment Term
                                </button>
                            </li>
                        </span>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-os" aria-controls="navs-pills-os" aria-selected="false"
                                tabindex="-1" style="border: 1px solid #696cff;" name="btn_payment_standard_date_driven"
                                id="payment_standard_date_driven_2" value="2">
                                Date Driven Payment Term
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <h4 class="py-2 mb-2"><span class="text-muted fw-light"></span>
                <div id="main-head-label">List Standard Payment Terms </div>
            </h4>
            <div class="row mb-3">
                @include('account_payment_term.__search')
                <div class="card">
                    <div class="row mb-2">
                        <div class="col">
                            <table class="datatables-basic table tables-basic border-top table-striped"
                                id="accountStandardPaymentTermTable">
                                <thead class="table-header-bold">
                                    <tr class="odd gradeX">
                                        <th class="center">Sl.No</th>
                                        <th>Code</th>
                                        <th>Label</th>
                                        <th>Types</th>
                                        <th>Net Due <span id="lbl-name">In</span></th>
                                        <th>Usage</th>
                                        <th>Actions</th>
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
    @include('account_payment_term.__model')
@endsection
@section('scripts')
    @include('account_payment_term.__script')
@endsection
