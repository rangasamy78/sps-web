@extends('layouts.admin')

@section('title', 'Supplier')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home /</span> Supplier</a></h4>
    <!-- Product List Widget -->

    <div class="card mb-4">
      <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
          <div class="row gy-4 gy-sm-1">
            <div class="col-sm-6 col-lg-3">
              <div
                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                <div>
                  <h6 class="mb-2">Total Supplier</h6>
                  <h4 class="mb-2">{{$totalSupplier}}</h4>
                  <p class="mb-0">
                    <span class="text-muted me-2">0k orders</span><span class="badge bg-label-success">+0.0%</span>
                  </p>
                </div>
                <div class="avatar me-sm-4">
                  <span class="avatar-initial rounded bg-label-secondary">
                    <i class="bx bx-user bx-sm"></i>
                  </span>
                </div>
              </div>
              <hr class="d-none d-sm-block d-lg-none me-4" />
            </div>
            <div class="col-sm-6 col-lg-3">
              <div
                class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                <div>
                  <h6 class="mb-2">Parent Supplier</h6>
                  <h4 class="mb-2">{{$totalParentSupplier}}</h4>
                  <p class="mb-0">
                    <span class="text-muted me-2">0k orders</span><span class="badge bg-label-success">+0.0%</span>
                  </p>
                </div>
                <div class="avatar me-lg-4">
                  <span class="avatar-initial rounded bg-label-secondary">
                    <i class="bx bx-group bx-sm"></i>
                  </span>
                </div>
              </div>
              <hr class="d-none d-sm-block d-lg-none" />
            </div>
            <div class="col-sm-6 col-lg-3">
              <div
                class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                <div>
                  <h6 class="mb-2">Discount</h6>
                  <h4 class="mb-2">{{$totalDiscountSupplier}}</h4>
                  <p class="mb-0 text-muted">0k orders</p>
                </div>
                <div class="avatar me-sm-4">
                  <span class="avatar-initial rounded bg-label-secondary">
                    <i class="bx bx-purchase-tag bx-sm"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <h6 class="mb-2">Multi Location Supplier</h6>
                  <h4 class="mb-2">{{$totalMultiLocationSupplier}}</h4>
                  <p class="mb-0">
                    <span class="text-muted me-2">0 orders</span><span class="badge bg-label-danger">-0.0%</span>
                  </p>
                </div>
                <div class="avatar">
                  <span class="avatar-initial rounded bg-label-secondary">
                    <i class="bx bx-map bx-sm"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Product List Table -->
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Search Supplier:</h5>
        <div class="d-flex justify-content-between align-items-center row py-3 gap-2 gap-md-0">
          @include('supplier.__search')
        </div>
      </div>
      <div class="card-datatable table-responsive">
        <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesSupplier">
          <thead class="table-header-bold">
            <tr>
              <th>Sl.No</th>
              <th>Name</th>
              <th>Currency</th>
              <th>Type</th>
              <th>Address</th>
              <th>Phones</th>
              <th>Location</th>
              <th>Pmt.Terms</th>
              <th>Language</th>
              <th>Notes</th>
              <th>Status</th>
              <th>actions</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

      </div>
    </div>
  </div>
  <!-- / Content -->



  <div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('supplier.__script')
<!-- <script src="{{asset('public/assets/js/app-ecommerce-product-list.js')}}"></script> -->
@endsection