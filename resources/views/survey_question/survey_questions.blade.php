@extends('layouts.admin')
@section('title', 'Survey Question')
@section('styles')
@endsection
@section('content')
{{-- <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> Survey Questions</h4>
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="btn-group">
                            </div>
                            <button class="btn btn-secondary create-new btn-primary" type="button"
                                id="createSurveyQuestion"><span><i class="bx bx-plus me-1"></i> <span
                                        class="d-none d-lg-inline-block">Create New Survey Question</span></span></button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered data-table  table-striped" id="datatable" style="width: 100%">
                    <thead>
                        <tr>
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
    </div> --}}
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
          <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Survey Questions</h4>
          @include('survey_question.__search')
          <div class="row mb-3">
          <div class="col">
            <div class="card">
              <div class="row mb-2 p-2">
                <div class="col">
                  <table class="datatables-basic table tables-basic border-top table-striped" id="surveyQuestionTable">
                    <thead>
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
