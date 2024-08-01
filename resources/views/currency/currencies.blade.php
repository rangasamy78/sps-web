@extends('layouts.admin')

@section('title', 'Home Page - UI elements')

@section('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- //toast -->
    <div class="container-toast ">

    </div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>List of Currencies</h4>
    <div class="row mb-3">
      <!-- DataTable with Buttons -->

      <div class="card">
        <!-- </div> -->
        <div class="row mb-2">

          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="currencyTable">
              <thead>
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

<!-- / Content -->
@include('currency.__model')
@endsection

@section('scripts')
@include('currency.__script')
@endsection