@extends('layouts.admin')

@section('title', 'Vendor Type')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span>Vendor Type</h4>
    @include('vendor_type.__search')
    <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="row mb-2 p-2">
          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="datatable">
              <thead>
                <tr class="odd gradeX">
                  <th>Sl.No</th>
                  <th>Vendor Type Name</th>
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
@include('vendor_type.__model')
@endsection
@section('scripts')
@include('vendor_type.__scripts')
@endsection
