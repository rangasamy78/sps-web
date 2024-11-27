@extends('layouts.admin')

@section('title', 'Pre Purchase Request')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Home / </span> Pre Purchase Request</a></h4>
    @include('pre_purchase_request.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Pre Purchase</th>
                    <th>Request Date</th>
                    <th>Supplier</th>
                    <th>Req. Ship Date</th>
                    <th>Requested By</th>
                    <th>Requests</th>
                    <th>Responses</th>
                    <th>Accepted PO #</th>
                    <th>PO Date</th>
                    <th>Terms</th>
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
@include('pre_purchase_request.__scripts')
@endsection
