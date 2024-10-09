@extends('layouts.admin')

@section('title', 'Service')

@section('styles')
<style>
  .product-link {
    color: black;
    text-decoration: none;
  }

  .product-link:hover {
    text-decoration: underline;
  }
</style>
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home / </span>Service</a></h4>
    @include('service.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Group</th>
                    <th>Price 1</th>
                    <th>Units</th>
                    {{-- <th>Price Range</th> --}}
                    {{-- <th>Pref.Vendor</th> --}}
                    <th>Status</th>
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
</div>

@endsection
@section('scripts')
@include('service.__scripts')
@endsection