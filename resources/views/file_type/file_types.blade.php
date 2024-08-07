@extends('layouts.admin')
@section('title', 'File Types')
@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> File Types</h4>
    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="btn-group">
                            </div>
                            <button class="btn btn-secondary create-new btn-primary" type="button"
                                id="createFileType"><span><i class="bx bx-plus me-1"></i> <span
                                        class="d-none d-lg-inline-block">Create File Types</span></span></button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered data-table  table-striped" id="datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th><b>S.No</b></th>
                            <th><b>View In</b></th>
                            <th><b>File Type</b></th>
                            <th width="150px"><b>Action</b></th>
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
    @include('file_type.__model')
</div>

<!-- / Content -->
@endsection
@section('scripts')
@include('file_type.__scripts')
@endsection