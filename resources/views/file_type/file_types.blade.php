@extends('layouts.admin')
@section('title', 'File Types')
@section('styles')
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> File Types</h4>
    @include('file_type.__search')
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="table table-bordered data-table  table-striped" id="datatable" style="width: 100%">
                    <thead class="table-header-bold">
                        <tr>
                            <th>S.No</th>
                            <th>View In</th>
                            <th>File Type</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('file_type.__model')
    @include('file_type.__import')
</div>
@endsection
@section('scripts')
@include('file_type.__scripts')
@endsection
