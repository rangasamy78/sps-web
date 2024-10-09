@extends('layouts.admin')

@section('title', 'Associate')

@section('styles')
<style>
  .associate-link {
    color: black;
    text-decoration: none; 
}

.associate-link:hover {
    text-decoration: underline; 
}

</style>
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home / </span>Associate</a></h4>
    @include('associate.__search')
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
                    <th>Type</th>
                    <th>Location</th>
                    <th>Address</th>
                    <th>Phones</th>
                    <th>Email</th>
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
@include('associate.__scripts')
@endsection
