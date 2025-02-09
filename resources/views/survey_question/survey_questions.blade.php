@extends('layouts.admin')
@section('title', 'Survey Question')
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Survey Questions</h4>
    @include('survey_question.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="surveyQuestionTable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>S.No</th>
                    <th>Transaction</th>
                    <th>Short label</th>
                    <th>Question</th>
                    <th width="150px">Action</th>
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
@include('survey_question.__model')
@endsection
@section('scripts')
@include('survey_question.__scripts')
@endsection