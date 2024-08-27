@extends('layouts.admin')

@section('title', 'How did you hear Option')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span>How did you hear Option</h4>
    @include('about_us_option.__search')
    <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="row mb-2 p-2">
          <div class="col">
            <table class=" datatables-basic table tables-basic border-top table-striped" id="aboutUsOptionTable">
              <thead>
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
@include('about_us_option.__model')
@endsection
@section('scripts')
@include('about_us_option.__script')
@endsection
