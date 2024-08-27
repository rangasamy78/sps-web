@extends('layouts.admin')

@section('title', 'Tax Exempt Reason')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span>Tax Exempt Reason</h4>
    @include('tax_exempt_reason.__search')
    <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="row mb-2 p-2">
          <div class="col">
            <table class="datatables-basic table tables-basic border-top table-striped" id="taxExemptReasonTable">
              <thead class="table-header-bold">
                <tr class="odd gradeX">
                  <th>Sl.No</th>
                  <th>Reason</th>
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
@include('tax_exempt_reason.__model')
@endsection
@section('scripts')
@include('tax_exempt_reason.__script')
@endsection