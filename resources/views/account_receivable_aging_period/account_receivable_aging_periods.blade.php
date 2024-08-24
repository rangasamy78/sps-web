@extends('layouts.admin')

@section('title', 'Account Receivable Aging Period')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Account Receivable Aging Period</h4>
    <form id="accountReceivableAgingPeriodForm" class="form-horizontal">
      <div class="row mb-3">
        <div class="col-lg-7 col-md-10 col-sm-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Aging Periods - AR</h5>
            </div>
            <div class="card-body">
              <div class="row mb-3 align-items-center">
                <div class="col-12 col-md-2">
                  <label class="form-label" for="basic-icon-default-phone">Age By</label>
                </div>
                <div class="col-6 col-md-4">
                  <button type="button" class="btn btn-md btn-label-primary w-100 mb-2 mb-md-0" id="btn_invoice_date">Invoice Date</button>
                </div>
                <div class="col-6 col-md-4">
                  <button type="button" class="btn btn-md btn-label-primary w-100 active" id="btn_due_date">Due Date</button>
                </div>
              </div>
              <div class="row">
                <input type="hidden" id="account_receivable_aging_period_id" readonly class="form-control" name="account_receivable_aging_period_id" value="{{ isset($accountReceivableAgingPeriod['id']) ? $accountReceivableAgingPeriod['id'] : 0 }}">
              </div>
              <!-- invoice Date -->
              <div id="invoice_date" style="display:none">
                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_invoice_date_start_1">Period 1:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" id="ar_invoice_date_start_1" readonly class="form-control" name="ar_invoice_date_start_1" value="0">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_invoice_date_end_1">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_invoice_date_end_1" id="ar_invoice_date_end_1" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_end_1']) ? $accountReceivableAgingPeriod['ar_invoice_date_end_1'] : null;}}" onchange="getInvoiceDateValue(this.id)">
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_invoice_date_start_2">Period 2:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" id="ar_invoice_date_start_2" readonly class="form-control" name="ar_invoice_date_start_2" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_start_2']) ? $accountReceivableAgingPeriod['ar_invoice_date_start_2'] : null;}}">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_invoice_date_end_2">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_invoice_date_end_2" id="ar_invoice_date_end_2" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_end_2']) ? $accountReceivableAgingPeriod['ar_invoice_date_end_2'] : null;}}" onchange="getInvoiceDateValue(this.id)">
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_invoice_date_start_3">Period 3:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" readonly name="ar_invoice_date_start_3" id="ar_invoice_date_start_3" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_start_3']) ? $accountReceivableAgingPeriod['ar_invoice_date_start_3'] : null;}}">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_invoice_date_end_3">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_invoice_date_end_3" id="ar_invoice_date_end_3" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_end_3']) ? $accountReceivableAgingPeriod['ar_invoice_date_end_3'] : null;}}" onchange="getInvoiceDateValue(this.id)">
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_invoice_date_start_4">Period 4:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" readonly name="ar_invoice_date_start_4" id="ar_invoice_date_start_4" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_start_4']) ? $accountReceivableAgingPeriod['ar_invoice_date_start_4'] : null;}}">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_invoice_date_end_4">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_invoice_date_end_4" id="ar_invoice_date_end_4" value="{{isset($accountReceivableAgingPeriod['ar_invoice_date_end_4']) ? $accountReceivableAgingPeriod['ar_invoice_date_end_4'] : null;}}" onchange="getInvoiceDateValue(this.id)">
                    </div>
                  </div>
                </div>
                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_invoice_date_start_5">Period 5:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <span id="ar_invoice_date_start_5">Over {{isset($accountReceivableAgingPeriod['ar_invoice_date_end_4']) ? $accountReceivableAgingPeriod['ar_invoice_date_end_4'] : 150;}} days</span>
                    </div>
                  </div>
                </div>
              </div>
              <div id="due_date">
                <div class="row mb-3">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_due_date_start_1">Period 1:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <span id="ar_due_date_start_1">Current</span>
                    </div>
                  </div>
                </div>
                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_due_date_start_2">Period 2:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" id="ar_due_date_start_2" readonly class="form-control" name="ar_due_date_start_2" value="1">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_due_date_end_2">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_due_date_end_2" id="ar_due_date_end_2" value="{{isset($accountReceivableAgingPeriod['ar_due_date_end_2']) ? $accountReceivableAgingPeriod['ar_due_date_end_2'] : null;}}"
                        onchange="getDueDateValue(this.id)">
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_due_date_start_3">Period 3:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" readonly name="ar_due_date_start_3" id="ar_due_date_start_3" value="{{isset($accountReceivableAgingPeriod['ar_due_date_start_3']) ? $accountReceivableAgingPeriod['ar_due_date_start_3'] : null;}}">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_due_date_end_3">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_due_date_end_3" id="ar_due_date_end_3" value="{{isset($accountReceivableAgingPeriod['ar_due_date_end_3']) ? $accountReceivableAgingPeriod['ar_due_date_end_3'] : null;}}" onchange="getDueDateValue(this.id)">
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_due_date_start_4">Period 4:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" readonly name="ar_due_date_start_4" id="ar_due_date_start_4" value="{{isset($accountReceivableAgingPeriod['ar_due_date_start_4']) ? $accountReceivableAgingPeriod['ar_due_date_start_4'] : null;}}">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_due_date_end_4">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_due_date_end_4" id="ar_due_date_end_4" value="{{isset($accountReceivableAgingPeriod['ar_due_date_end_4']) ? $accountReceivableAgingPeriod['ar_due_date_end_4'] : null;}}" onchange="getDueDateValue(this.id)">
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_due_date_start_5">Period 5:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" readonly name="ar_due_date_start_5" id="ar_due_date_start_5" value="{{isset($accountReceivableAgingPeriod['ar_due_date_start_5']) ? $accountReceivableAgingPeriod['ar_due_date_start_5'] : null;}}">
                    </div>
                  </div>
                  <div class="col-12 col-md-1 text-center text-md-start">
                    <label class="form-label" for="ar_due_date_end_5">to</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <input type="number" class="form-control" name="ar_due_date_end_5" id="ar_due_date_end_5" value="{{isset($accountReceivableAgingPeriod['ar_due_date_end_5']) ? $accountReceivableAgingPeriod['ar_due_date_end_5'] : null;}}" onchange="getDueDateValue(this.id)">
                    </div>
                  </div>
                </div>
                <div class="row mb-3 align-items-center">
                  <div class="col-12 col-md-2">
                    <label class="form-label" for="ar_due_date_start_6">Period 6:</label>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                      <span id="ar_due_date_start_6">Over {{isset($accountReceivableAgingPeriod['ar_due_date_end_5']) ? $accountReceivableAgingPeriod['ar_due_date_end_5'] : 150;}} days</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-check pb-">
                <label for="do_not_show_on_report" class="form-check-label">Do not show Customer Deposits in AR Reports/Customer Statements</label>
                <input class="form-check-input" type="checkbox" id="do_not_show_on_report" name="do_not_show_on_report" value="1" {{ isset($accountReceivableAgingPeriod['do_not_show_on_report']) && $accountReceivableAgingPeriod['do_not_show_on_report'] == 1 ? 'checked' : '' }}>
              </div>
              <button type="submit" class="btn btn-primary float-end" id="savedata" name="savedata">Save Aging Period</button>
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
@include('account_receivable_aging_period.__script')
@endsection
