@extends('layouts.admin')

@section('title', 'Service Category')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Service Category</h4>
    @include('service_category.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="serviceCategoryTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Service Category</th>
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
@include('service_category.__model')
@endsection
@section('scripts')
@include('service_category.__script')
@endsection