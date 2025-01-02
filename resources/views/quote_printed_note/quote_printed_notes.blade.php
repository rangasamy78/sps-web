@extends('layouts.admin')

@section('title', 'Quote Printed Notes')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Quote Printed Notes</h4>
    @include('quote_printed_note.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="quotePrintedNoteTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Quote Printed Note</th>
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
@include('quote_printed_note.__model')
@endsection
@section('scripts')
@include('quote_printed_note.__script')
@endsection