@extends('layouts.admin')

@section('title', 'Supplier Cost List Label')

@section('styles')
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- //toast -->
    <div class="container-toast ">
    </div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>Supplier Cost List Label</h4>
    <div class="row mb-3">
      <!-- DataTable with Buttons -->

      <div class="card">
        <!-- </div> -->
        <div class="row mb-2">
          <div class="col">
            <table class="datatables-basic table tables-basic border-top table-striped" id="supplierCostListLabelTable">
              <thead>
                <tr class="odd gradeX">
                  <th class="center">Sl.No</th>
                  <th>Cost Level</th>
                  <th>Cost Code</th>
                  <th>Cost Label</th>
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
@include('supplier_cost_list_label.__model')
@endsection

@section('scripts')
@include('supplier_cost_list_label.__script')
@endsection