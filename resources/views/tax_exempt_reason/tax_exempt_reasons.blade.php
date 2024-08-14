@extends('layouts.admin')

@section('title', 'Tax Exempt Reason')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- //toast -->
    <div class="container-toast ">
    </div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>Tax Exempt Reason</h4>
    <div class="row mb-3">
      <!-- DataTable with Buttons -->

      <div class="card">
        <!-- </div> -->
        <div class="row mb-2">
          <div class="col">
            <table class="datatables-basic table tables-basic border-top table-striped" id="taxExemptReasonTable">
              <thead>
                <tr class="odd gradeX">
                  <th class="center">Sl.No</th>
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

<!-- / Content -->
@include('tax_exempt_reason.__model')
@endsection

@section('scripts')
@include('tax_exempt_reason.__script')
@endsection