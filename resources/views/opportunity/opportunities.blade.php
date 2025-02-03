@extends('layouts.admin')

@section('title', 'Opportunity')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home /</span> Opportunity</a></h4>
    <!-- Product List Widget -->
    <div class="row">
      <div class="col-12 order-0 order-md-1">
        <!-- Navigation -->
        <div class="col-12  mx-auto card-separator">
          <div class="d-flex justify-content-between mb-3">
            @php
            $activeTab = request('tab', 'defaultTab'); // 'defaultTab' is the fallback
            @endphp
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
              <li class="nav-item me-3">
                <button class="nav-link {{ $activeTab == 'opportunities' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#opportunitiesTab">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Opportunity</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link {{ $activeTab == 'visits' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#visitsTab">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Visit</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link {{ $activeTab == 'samples' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#samplesTab">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Sample Order</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link {{ $activeTab == 'quotes' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#quotesTab">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Quote</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link {{ $activeTab == 'holds' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#holdsTab">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Hold</span>
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
                  @include('opportunity.all_opportunity.all_opportunities')
                  @include('opportunity.all_visit.all_visits')
                  @include('opportunity.all_sample_order.all_sample_orders')
                  @include('opportunity.all_quote.all_quotes')
                  @include('opportunity.all_hold.all_holds')
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
  @include('opportunity.all_visit.__model')
  @include('opportunity.all_sample_order.__model')
  @include('opportunity.all_quote.__model')
  @include('opportunity.all_hold.__model')
</div>
@endsection
@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab'); // Get the 'tab' parameter

    if (activeTab) {
      // Activate the corresponding tab
      const targetTab = document.querySelector(`[data-bs-target="#${activeTab}Tab"]`);
      const targetContent = document.querySelector(`#${activeTab}Tab`);
      if (targetTab && targetContent) {
        // Simulate clicking the tab
        targetTab.click();

        // Ensure tab content is visible
        targetContent.classList.add('active', 'show');
      }
    }
  });
</script>
@include('opportunity.__script')
@include('opportunity.all_visit.__script')
@include('opportunity.all_sample_order.__script')
@include('opportunity.all_quote.__script')
@include('opportunity.all_hold.__script')
@endsection