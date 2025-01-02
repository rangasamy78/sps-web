@extends('layouts.admin')

@section('title', 'Quote Footer')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Quote Footer</h4>
    @include('quote_Footer.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="quoteFooterTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Quote Footer</th>
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
@include('quote_footer.__model')
@endsection
@section('scripts')
@include('quote_footer.__script')
@endsection