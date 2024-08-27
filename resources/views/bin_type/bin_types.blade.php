@extends('layouts.admin')

@section('title', 'Bin Types')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> Bin Type</h4>
    @include('bin_type.__search')
    <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="row mb-2 p-2">
          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="binTypeTable">
              <thead>
                <tr class="odd gradeX">
                  <th>Sl.No</th>
                  <th>Bin Type</th>                  
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
@include('bin_type.__model')
@endsection
@section('scripts')
@include('bin_type.__script')
@endsection
