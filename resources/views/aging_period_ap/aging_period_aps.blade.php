@extends('layouts.admin')

@section('title', 'Aging Period - AP')

@section('styles')
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> Aging Periods - AP</h4>
        <div class="card">
            <div style="overflow:hidden;width:96%;margin:auto;">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row">
                        <div class="card mb-6">
                            <div class="row mt-2">
                                <input type="hidden"
                                    value="{{ isset($agingPeriodAPRepositoryDetail['id']) && $agingPeriodAPRepositoryDetail['id'] ? $agingPeriodAPRepositoryDetail['id'] : 0 }}"
                                    name="pick_ticket_restriction_id" id="pick_ticket_restriction_id">
                            </div>
                            <div class="col-xl-6">
                                <h5 class="card-header">Aging Periods - AP</h5>
                                <div class="card-body">
                                    <div class="container-toast mb-3">
                                        <ul class="nav nav-pills flex-wrap" role="tablist">
                                            <li class="nav-item col-12 col-sm-6 col-md-2 mt-2" role="presentation">
                                                <span class="col-md-2 card-subtitle">Age by</span>
                                            </li>
                                            <span class="me-3">
                                            <li class="nav-item" role="presentation">
                                                <button type="button" class="nav-link active" role="tab"
                                                    data-bs-toggle="tab" data-bs-target="#navs-pills-browser"
                                                    aria-controls="navs-pills-browser" aria-selected="true"
                                                    style="border: 1px solid #696cff;"
                                                    name="btn_invoice_due_date"
                                                    id="btn_invoice_due_date_1" value="1">
                                                    Invoice Date
                                                </button>
                                            </li>
                                            </span>
                                            <li class="nav-item" role="presentation">
                                                <button type="button" class="nav-link" role="tab"
                                                    data-bs-toggle="tab" data-bs-target="#navs-pills-os"
                                                    aria-controls="navs-pills-os" aria-selected="false" tabindex="-1"
                                                    style="border: 1px solid #696cff;"
                                                    name="btn_invoice_due_date"
                                                    id="btn_invoice_due_date_2" value="2">
                                                    Due Date
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <form name="agingPeriodAPForm" id="agingPeriodAPForm">
                                            <input type="hidden"
                                        value="{{ isset($agingPeriodAPRepositoryDetail['id']) && $agingPeriodAPRepositoryDetail['id'] ? $agingPeriodAPRepositoryDetail['id'] : 0 }}"
                                        name="aging_period_ap_id" id="aging_period_ap_id">
                                        <div class="mb-3 row" id="period_current_1" style="display:none">
                                            <label for="html5-search-input" class="col-md-2 card-subtitle mt-1">Period 1:</label>
                                            <div class="col-md-3">
                                                <label for="html5-search-input" class="col-md-6 card-subtitle mt-1">Current</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label for="html5-search-input" class="col-md-2 card-subtitle mt-1">Period<span id="aging_period_ap_1_lbl"></span>: <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_1_start" id="aging_period_ap_1_start" disabled value='0'>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span>to</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_1_end" id="aging_period_ap_1_end" value="{{ isset($agingPeriodAPRepositoryDetail['invoice_aging_period_ap_1_end']) && $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_1_end'] ? $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_1_end'] : '0' }}">
                                                <span class="text-danger error-text invoice_aging_period_ap_1_end_error" ></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label for="html5-search-input" class="col-md-2 card-subtitle mt-1">Period<span id="aging_period_ap_2_lbl"></span>: <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_2_start" id="aging_period_ap_2_start" disabled value="">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span>to</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_2_end" id="aging_period_ap_2_end" value="{{ isset($agingPeriodAPRepositoryDetail['invoice_aging_period_ap_2_end']) && $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_2_end'] ? $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_2_end'] : '0' }}">
                                                <span class="text-danger error-text invoice_aging_period_ap_2_end_error"></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label for="html5-search-input" class="col-md-2 card-subtitle mt-1">Period<span id="aging_period_ap_3_lbl"></span>: <sup style="color: red;font-size:1rem;"><b>*</b></sup></label>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_3_start" id="aging_period_ap_3_start" disabled value="">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span>to</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_3_end" id="aging_period_ap_3_end" value="{{ isset($agingPeriodAPRepositoryDetail['invoice_aging_period_ap_3_end']) && $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_3_end'] ? $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_3_end'] : '0' }}">
                                                <span class="text-danger error-text invoice_aging_period_ap_3_end_error"></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label for="html5-search-input" class="col-md-2 card-subtitle mt-1">Period <span id="aging_period_ap_4_lbl"></span>:</label>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_4_start" id="aging_period_ap_4_start" disabled value="">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span>to</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" type="number" name="aging_period_ap_4_end" id="aging_period_ap_4_end" value="{{ isset($agingPeriodAPRepositoryDetail['invoice_aging_period_ap_4_end']) && $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_4_end'] ? $agingPeriodAPRepositoryDetail['invoice_aging_period_ap_4_end'] : '0' }}">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="html5-search-input" class="col-md-2 card-subtitle mt-0">Period <span id="aging_period_ap_5_lbl"></span>:</label>
                                            <div class="col-md-3">
                                                <span>Over <span id="aging_period_ap_over_days"></span> days</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary float-end" name="savedata" id="savedata">Update Aging Periods</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('aging_period_ap.__scripts')
@endsection
