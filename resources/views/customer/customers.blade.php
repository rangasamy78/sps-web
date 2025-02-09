@extends('layouts.admin')

@section('title', 'Customer')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home / </span> Customer</a></h4>
    @include('customer.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Name</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>Phones</th>
                    <th>Sales Person</th>
                    <th>Status</th>
                    <th></th>
                    <th>Action</th>
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
@include('customer.__scripts')
@endsection
