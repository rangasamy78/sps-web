@extends('layouts.admin')

@section('title', 'Home Page - UI elements')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>List of Currencies</h4>
    @include('currency.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card">
          <div class="row mb-2 p-3">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="currencyTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Currency (Symbol)</th>
                    <th>Code</th>
                    <th>name</th>
                    <th>Exchange Rate</th>
                    <th>Last Updated</th>
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
@include('currency.__model')
@endsection

@section('scripts')
@include('currency.__script')
@endsection
