@extends('layouts.admin')

@section('title', 'Event')
<style>
.btn-group label {
    margin-right: 10px; /* Adjust this value as per your preference */
}
</style>
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home / </span>My Event</a></h4>
    @include('my_event.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
                <h5 class="card-header pb-0 text-center"><div id="statusFilterContainer"></div></h5>
                <table class="datatables-basic table tables-basic border-top table-striped" id="dataTable">
                    <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Entered By</th>
                    <th>Assigned To</th>
                    <th>Title / Description</th>
                    <th>Type</th>
                    <th>Sch. Date / Time</th>
                    <th>Transaction# / Job Name</th>
                    <th>Products / Price</th>
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
@include('my_event.__script')
@endsection
