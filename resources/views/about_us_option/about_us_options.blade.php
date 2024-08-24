@extends('layouts.admin')

@section('title', 'How did you hear Option')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>
      <span class="text-muted fw-light">Home / </span>How Did You Hear Options
    </h4>
    <div class="row mb-3">
      <div class="col">
        <!-- DataTable with Buttons -->
        <div class="card p-4 pt-0">
          <!-- </div> -->
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="aboutUsOptionTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>How did you hear Option</th>
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

<!-- / Content -->
@include('about_us_option.__model')
@endsection
@section('scripts')
@include('about_us_option.__script')
@endsection
