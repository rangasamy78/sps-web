@extends('layouts.admin')

@section('title', 'State Page')

@section('styles')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> State</h4>
        @include('state.__search')
        <div class="card">
            <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0"></h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <button class="btn btn-secondary create-new btn-primary" type="button"
                                    id="createState"><span><i class="bx bx-plus me-1"></i></span> <span
                                            class="d-none d-lg-inline-block">Create State</span></button>
                            </div>
                            <div class="dt-buttons btn-group flex-wrap">
                                <button class="btn btn-secondary create-new btn-primary" type="button"
                                    id="importState"><span><i class="bx bx-plus me-1"></i></span> <span
                                    class="d-none d-lg-inline-block">Import State</span></button>

                            </div>
                            <button class="btn btn-secondary create-new btn-primary btn-sm" type="button" id="downloadState" title="State Template" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="State Template">
                                <span><i class="bx bx-download bx-sm"></i></span>
                            </button>
                        </div>
                    </div>

                    <table class="table table-bordered data-table table-striped" id="datatable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>State Name</th>
                                <th>State Code</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Ajax Sourced Server-side -->

        <!--/ Responsive Datatable -->
        @include('state.__model')
        @include('state.__import')
    </div>
    <!-- / Content -->
@endsection

@section('scripts')
    @include('state.__scripts')
@endsection
