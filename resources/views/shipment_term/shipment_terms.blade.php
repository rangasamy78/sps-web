@extends('layouts.admin')

@section('title', 'Shipment Terms')

@section('styles')
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/editor.css')}}" />
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- //toast -->
    <div class="container-toast">
    </div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Shipment Terms</h4>
    <div class="row mb-3">
      <!-- DataTable with Buttons -->

      <div class="card p-4 pt-0">
        <!-- </div> -->
        <div class="row">

          <div class="col">
            <table class="datatables-basic table tables-basic border-top table-striped" id="shipmentTermTable">
              <thead class="table-header-bold">
                <tr class="odd gradeX">
                  <th>Sl.No</th>
                  <th>Shipment Term Name</th>
                  <th>Description</th>
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
@include('shipment_term.__model')
@endsection

@section('scripts')
<script src="{{asset('public/assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('public/assets/vendor/libs/quill/quill.js')}}"></script>
@include('shipment_term.__script')
@endsection
