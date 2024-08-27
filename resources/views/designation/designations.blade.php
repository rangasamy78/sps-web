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
    <div class="container-toast">

    </div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>List of Designation</h4>
    @include('designation.__search')
    <div class="row mb-3">
      <!-- DataTable with Buttons -->

      <div class="card p-4 pt-0">
        <!-- </div> -->
        <div class="row">

          <div class="col">
            <table class="datatables-basic table tables-basic border-top table-striped" id="createDesignation">
              <thead class="table-header-bold">
                <tr class="odd gradeX">
                  <th>Sl.No</th>
                  <th>Department</th>
                  <th>Designation</th>
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
@include('designation.__model')
@endsection

@section('scripts')
@include('designation.__script')
@endsection
