@extends('layouts.admin')

@section('title', 'Account Sub Type')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- //toast -->
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Account Sub Type</h4>
    <div class="row mb-3">
      <div class="col">
        <!-- DataTable with Buttons -->
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="accountSubTypeTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Sub Type Name</th>
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

  <!-- / Content -->
  @include('account_sub_type.__model')
  @endsection
  @section('scripts')
  @include('account_sub_type.__script')
  @endsection