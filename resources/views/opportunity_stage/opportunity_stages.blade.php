@extends('layouts.admin')

@section('title', 'Opportunity Stage')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span>Opportunity Stage</h4>
    @include('opportunity_stage.__search')
    <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="row mb-2 p-2">
          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="datatable">
              <thead>
                <tr class="odd gradeX">
                  <th>Sl.No</th>
                  <th>Opportunity Stage</th>
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
@include('opportunity_stage.__model')
@endsection
@section('scripts')
@include('opportunity_stage.__scripts')
@endsection
