@extends('layouts.admin')

@section('title', 'Account')

@section('styles')
<style>

</style>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span> Account</h4>
    <!-- Product List Widget -->
    <div class="row">
      <div class="col-12 order-0 order-md-1">
        <!-- Navigation -->
        <div class="col-12  mx-auto card-separator">
          <div class="d-flex justify-content-between mb-3">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
              <li class="nav-item me-3">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allAccount">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Account</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#newAddcount" onclick="window.location.href='{{ route('accounts.create') }}';">
                  <i class="bx bx-plus me-sm-1"></i>
                  <span class="align-middle">New Account</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allTrialBalance">
                  <i class="bx bx-receipt me-2"></i>
                  <span class="align-middle">Trial Balance</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allTrialBalanceByLocation">
                  <i class="bx bx-map me-2"></i>
                  <span class="align-middle">Trial Balance-By Location</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inActiveTab">
                  <i class="bx bx-x me-2"></i>
                  <span class="align-middle">In Active Account</span>
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
                  @include('account.all_account_list.all_account_lists')
                  @include('account.in_active_account.in_active_accounts')
                  @include('account.trial_balance.trial_balances')
                  @include('account.trial_balance_by_location.trial_balance_by_locations')
                </div>
              </div>
              <!-- /Options-->
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
@include('account.in_active_account.__script')
@include('account.trial_balance.__script')
@include('account.trial_balance_by_location.__script')
@endsection