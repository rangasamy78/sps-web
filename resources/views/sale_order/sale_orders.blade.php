@extends('layouts.admin')

@section('title', 'Sale Order')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/editor.css')}}" />
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home /</span> Sale Order</a></h4>
    <div class="row">
      <div class="col-12 order-0 order-md-1">
        <div class="col-12  mx-auto card-separator">
          <div class="d-flex justify-content-between mb-3">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
              <li class="nav-item me-3">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allSaleOrder">
                  <i class="bx bx-wallet me-sm-1"></i>
                  <span class="align-middle">All Sale Order</span>
                </button>
              </li>
            </ul>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-header">
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="tab-content p-0 pe-md-5  ">
                  @include('sale_order.all_sale_order.all_sale_orders')
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
@include('sale_order.__script')
<script src="{{asset('public/assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('public/assets/vendor/libs/quill/quill.js')}}"></script>
@endsection
