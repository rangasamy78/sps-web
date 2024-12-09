@extends('layouts.admin')

@section('title', 'Opportunity')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
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
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
              <li class="nav-item me-3">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allOpportunity">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Opportunity</span>
                </button>
              </li>
              <li class="nav-item me-3">
                <button class="nav-link" id="allVisitTab" data-bs-toggle="tab" data-bs-target="#allVisit">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Visit</span>
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
</div>
@endsection
@section('scripts')
@include('opportunity.__script')
@include('opportunity.all_visit.__script')
@endsection