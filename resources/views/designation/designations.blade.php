@extends('layouts.admin')

@section('title', 'Designation')

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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>List of Designation</h4>
    <div class="row mb-3">
      <!-- DataTable with Buttons -->

      <div class="card">
        <!-- </div> -->
        <div class="row mb-2">

          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="createDesignation">
              <thead>
                <tr class="odd gradeX">
                  <th><b>Sl.No</b></th>
                  <th><b>Department</b></th>
                  <th><b>Designation</b></th>
                  <th><b>Actions</b></th>
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
@include('designation.__model')
@endsection

@section('scripts')
@include('designation.__script')
@endsection