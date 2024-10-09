@extends('layouts.admin')

@section('title', 'Non Inventory Expenditure')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home / </span>Non Inventory Expenditure</a></h4>
    @include('expenditure.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>Print Name</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>Phones</th>
                    <th>Location</th>
                    <th>Pmt.Terms / Credit Limit</th>
                    <th>Account</th>
                    <th>Internal Notes</th>
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
@include('expenditure.__script')
@endsection
