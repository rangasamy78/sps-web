@extends('layouts.admin')

@section('title', 'How did you hear Option')

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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>
     How Did You Hear Options </h4>
    <div class="row mb-3">
      <!-- DataTable with Buttons -->
      <div class="card">
        <!-- </div> -->
        <div class="row mb-2">

          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="aboutUsOptionTable">
              <thead>
                <tr class="odd gradeX">
                  <th class="center"><b>Sl.No</b></th>
                  <th><b>How did you hear Option</b></th>
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
@include('about_us_option.__model')
@endsection
@section('scripts')
@include('about_us_option.__script')
@endsection